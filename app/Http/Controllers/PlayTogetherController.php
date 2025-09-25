<?php

namespace App\Http\Controllers;

use App\Models\PlayTogether;
use App\Models\PlayTogetherParticipant;
use App\Models\PlayTogetherChat;
use App\Models\Venue;
use App\Models\Sport;
use App\Models\UserSkillProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlayTogetherController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = PlayTogether::with(['sport', 'venue', 'organizer', 'participants.user'])
            ->where('status', '!=', 'cancelled')
            ->where('scheduled_time', '>', now());

        // Filter by sport
        if ($request->filled('sport_id')) {
            $query->where('sport_id', $request->sport_id);
        }

        // Filter by location/venue
        if ($request->filled('venue_id')) {
            $query->where('venue_id', $request->venue_id);
        }

        // Filter by date
        if ($request->filled('date')) {
            $date = Carbon::parse($request->date);
            $query->whereDate('scheduled_time', $date);
        }

        // Filter by skill level
        if ($request->filled('skill_level')) {
            $query->where('required_skill_level', $request->skill_level);
        }

        // Filter by cost
        if ($request->filled('max_cost')) {
            $query->where('price_per_person', '<=', $request->max_cost);
        }

        // Search by title or description
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        $events = $query->orderBy('scheduled_time', 'asc')->paginate(12);
        
        // Additional data for filters
        $sports = Sport::all();
        $venues = Venue::all();
        
        return view('play-together.index', compact('events', 'sports', 'venues'));
    }

    public function show($id)
    {
        $event = PlayTogether::with([
            'sport', 
            'venue', 
            'organizer',
            'participants.user.skillProfile',
            'chats.user'
        ])->findOrFail($id);

        $userParticipation = null;
        if (Auth::check()) {
            $userParticipation = $event->participants()
                ->where('user_id', Auth::id())
                ->first();
        }

        return view('play-together.show', compact('event', 'userParticipation'));
    }

    public function create()
    {
        $sports = Sport::all();
        $venues = Venue::all();
        
        return view('play-together.create', compact('sports', 'venues'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'sport_id' => 'required|exists:sports,id',
            'venue_id' => 'nullable|exists:venues,id',
            'location' => 'nullable|string|max:255',
            'scheduled_date' => 'required|date|after_or_equal:today',
            'scheduled_time' => 'required|date_format:H:i',
            'max_participants' => 'required|integer|min:2|max:50',
            'skill_level' => 'required|in:beginner,intermediate,advanced,professional',
            'price_per_person' => 'nullable|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            // Combine date and time into datetime for scheduled_time field
            $scheduledDateTime = Carbon::parse($validated['scheduled_date'] . ' ' . $validated['scheduled_time']);
            
            // Prepare data for creation
            $eventData = [
                'title' => $validated['title'],
                'description' => $validated['description'],
                'sport_id' => $validated['sport_id'],
                'venue_id' => $validated['venue_id'] ?? null,
                'location' => $validated['location'] ?? null,
                'scheduled_date' => $validated['scheduled_date'],
                'scheduled_time' => $scheduledDateTime, // This is now a full datetime
                'max_participants' => $validated['max_participants'],
                'skill_level' => $validated['skill_level'],
                'price_per_person' => $validated['price_per_person'] ?? 0,
                'organizer_id' => Auth::id(),
                'organizer_type' => 'App\\Models\\User',
                'status' => 'active'
            ];

            $event = PlayTogether::create($eventData);

            // Auto-join organizer
            PlayTogetherParticipant::create([
                'play_together_id' => $event->id,
                'user_id' => Auth::id(),
                'approval_status' => 'auto_approved',
                'status' => 'joined',
                'joined_at' => now()
            ]);

            // Send welcome message
            PlayTogetherChat::createSystemMessage(
                $event->id,
                "Event '{$event->title}' dibuat oleh {$event->organizer->name}"
            );

            DB::commit();
            return redirect()->route('play-together.show', $event)
                ->with('success', 'Event berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()
                ->with('error', 'Gagal membuat event: ' . $e->getMessage());
        }
    }

    public function join(Request $request, $id)
    {
        $event = PlayTogether::findOrFail($id);
        $user = Auth::user();

        // Check if already joined
        $existingParticipation = $event->participants()
            ->where('user_id', $user->id)
            ->first();

        if ($existingParticipation) {
            return back()->with('error', 'Anda sudah bergabung dalam event ini.');
        }

        // Check if event is full
        if ($event->participants()->count() >= $event->max_participants) {
            return back()->with('error', 'Event sudah penuh.');
        }

        // Check skill level requirement
        $userSkill = $user->skillProfile()->where('sport_id', $event->sport_id)->first();
        $approvalStatus = 'pending';

        if (!$event->requires_approval) {
            $approvalStatus = 'auto_approved';
        } elseif ($event->auto_approve_same_skill && $userSkill && 
                  $userSkill->skill_level === $event->required_skill_level) {
            $approvalStatus = 'auto_approved';
        }

        $participant = PlayTogetherParticipant::create([
            'play_together_id' => $event->id,
            'user_id' => $user->id,
            'approval_status' => $approvalStatus,
            'status' => $approvalStatus === 'auto_approved' ? 'joined' : 'pending',
            'joined_at' => $approvalStatus === 'auto_approved' ? now() : null
        ]);

        if ($approvalStatus === 'auto_approved') {
            // Create payment record if needed
            if ($event->is_paid_event) {
                $participant->createPaymentRecord();
            }

            PlayTogetherChat::createSystemMessage(
                $event->id,
                "{$user->name} bergabung dengan event"
            );

            return back()->with('success', 'Berhasil bergabung dengan event!');
        } else {
            PlayTogetherChat::createSystemMessage(
                $event->id,
                "{$user->name} meminta bergabung dengan event"
            );

            return back()->with('success', 'Permintaan bergabung telah dikirim. Menunggu persetujuan organizer.');
        }
    }

    public function leave($id)
    {
        $event = PlayTogether::findOrFail($id);
        $user = Auth::user();

        $participation = $event->participants()
            ->where('user_id', $user->id)
            ->first();

        if (!$participation) {
            return back()->with('error', 'Anda tidak terdaftar dalam event ini.');
        }

        // Check if organizer
        if ($event->organizer_id === $user->id) {
            return back()->with('error', 'Organizer tidak bisa keluar dari event. Batalkan event jika diperlukan.');
        }

        $participation->update([
            'status' => 'cancelled',
            'left_at' => now()
        ]);

        PlayTogetherChat::createSystemMessage(
            $event->id,
            "{$user->name} keluar dari event"
        );

        return back()->with('success', 'Berhasil keluar dari event.');
    }

    public function approveParticipant(Request $request, $id, $participantId)
    {
        $event = PlayTogether::findOrFail($id);
        
        // Check if user is organizer
        if ($event->organizer_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $participant = $event->participants()->findOrFail($participantId);
        
        if ($participant->approval_status !== 'pending') {
            return response()->json(['error' => 'Participant already processed'], 400);
        }

        $participant->approve();

        return response()->json(['success' => true, 'message' => 'Participant approved']);
    }

    public function rejectParticipant(Request $request, $id, $participantId)
    {
        $event = PlayTogether::findOrFail($id);
        
        // Check if user is organizer
        if ($event->organizer_id !== Auth::id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $participant = $event->participants()->findOrFail($participantId);
        
        if ($participant->approval_status !== 'pending') {
            return response()->json(['error' => 'Participant already processed'], 400);
        }

        $participant->reject($request->reason);

        return response()->json(['success' => true, 'message' => 'Participant rejected']);
    }

    public function sendMessage(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $event = PlayTogether::findOrFail($id);
        $user = Auth::user();

        // Check if user is participant
        $participation = $event->participants()
            ->where('user_id', $user->id)
            ->where('approval_status', 'approved')
            ->orWhere('approval_status', 'auto_approved')
            ->first();

        if (!$participation) {
            return response()->json(['error' => 'You must be an approved participant to send messages'], 403);
        }

        $chat = PlayTogetherChat::create([
            'play_together_id' => $event->id,
            'user_id' => $user->id,
            'message' => $request->message,
            'message_type' => 'user'
        ]);

        return response()->json([
            'success' => true,
            'message' => [
                'id' => $chat->id,
                'message' => $chat->message,
                'user_name' => $user->name,
                'created_at' => $chat->created_at->format('H:i')
            ]
        ]);
    }

    public function getMessages($id)
    {
        $event = PlayTogether::findOrFail($id);
        $user = Auth::user();

        // Check if user is participant
        $participation = $event->participants()
            ->where('user_id', $user->id)
            ->first();

        if (!$participation) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = $event->chats()
            ->with('user:id,name')
            ->orderBy('created_at', 'asc')
            ->take(50)
            ->get()
            ->map(function($chat) {
                return [
                    'id' => $chat->id,
                    'message' => $chat->message,
                    'user_name' => $chat->user ? $chat->user->name : 'System',
                    'message_type' => $chat->message_type,
                    'created_at' => $chat->created_at->format('H:i')
                ];
            });

        return response()->json(['messages' => $messages]);
    }

    public function myEvents()
    {
        $user = Auth::user();
        
        // Events organized by the user
        $organizedEvents = PlayTogether::where('organizer_id', $user->id)
            ->where('organizer_type', 'App\\Models\\User')
            ->with(['sport', 'venue', 'participants', 'chats'])
            ->orderBy('scheduled_date', 'desc')
            ->orderBy('scheduled_time', 'desc')
            ->get();

        // Events joined by the user (get participations, not events directly)
        $joinedEvents = PlayTogetherParticipant::where('user_id', $user->id)
            ->where('status', '!=', 'cancelled')
            ->with(['playTogether.sport', 'playTogether.venue', 'playTogether.organizer', 'playTogether.participants'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('play-together.my-events', compact('organizedEvents', 'joinedEvents'));
    }
}