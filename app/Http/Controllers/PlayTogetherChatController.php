<?php

namespace App\Http\Controllers;

use App\Models\PlayTogether;
use App\Models\PlayTogetherChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayTogetherChatController extends Controller
{
    public function index($playTogetherId)
    {
        $playTogether = PlayTogether::findOrFail($playTogetherId);
        $user = Auth::user();

        // Check if user is participant
        $participation = $playTogether->participants()
            ->where('user_id', $user->id)
            ->whereIn('approval_status', ['approved', 'auto_approved'])
            ->first();

        if (!$participation) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $messages = $playTogether->chats()
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->take(50)
            ->get()
            ->reverse()
            ->values()
            ->map(function($chat) {
                return [
                    'id' => $chat->id,
                    'message' => $chat->message,
                    'user_name' => $chat->user ? $chat->user->name : 'System',
                    'user_id' => $chat->user_id,
                    'message_type' => $chat->message_type,
                    'created_at' => $chat->created_at->format('Y-m-d H:i:s'),
                    'formatted_time' => $chat->created_at->format('H:i')
                ];
            });

        return response()->json(['messages' => $messages]);
    }

    public function store(Request $request, $playTogetherId)
    {
        $request->validate([
            'message' => 'required|string|max:1000'
        ]);

        $playTogether = PlayTogether::findOrFail($playTogetherId);
        $user = Auth::user();

        // Check if user is participant
        $participation = $playTogether->participants()
            ->where('user_id', $user->id)
            ->whereIn('approval_status', ['approved', 'auto_approved'])
            ->first();

        if (!$participation) {
            return response()->json(['error' => 'You must be an approved participant to send messages'], 403);
        }

        $chat = PlayTogetherChat::create([
            'play_together_id' => $playTogether->id,
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
                'user_id' => $user->id,
                'message_type' => 'user',
                'created_at' => $chat->created_at->format('Y-m-d H:i:s'),
                'formatted_time' => $chat->created_at->format('H:i')
            ]
        ]);
    }

    public function loadMore(Request $request, $playTogetherId)
    {
        $playTogether = PlayTogether::findOrFail($playTogetherId);
        $user = Auth::user();

        // Check if user is participant
        $participation = $playTogether->participants()
            ->where('user_id', $user->id)
            ->whereIn('approval_status', ['approved', 'auto_approved'])
            ->first();

        if (!$participation) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $lastMessageId = $request->get('last_message_id');
        $query = $playTogether->chats()
            ->with('user:id,name')
            ->orderBy('created_at', 'desc');

        if ($lastMessageId) {
            $query->where('id', '<', $lastMessageId);
        }

        $messages = $query->take(20)
            ->get()
            ->reverse()
            ->values()
            ->map(function($chat) {
                return [
                    'id' => $chat->id,
                    'message' => $chat->message,
                    'user_name' => $chat->user ? $chat->user->name : 'System',
                    'user_id' => $chat->user_id,
                    'message_type' => $chat->message_type,
                    'created_at' => $chat->created_at->format('Y-m-d H:i:s'),
                    'formatted_time' => $chat->created_at->format('H:i')
                ];
            });

        return response()->json(['messages' => $messages]);
    }

    public function markAsRead(Request $request, $playTogetherId)
    {
        $playTogether = PlayTogether::findOrFail($playTogetherId);
        $user = Auth::user();

        // Check if user is participant
        $participation = $playTogether->participants()
            ->where('user_id', $user->id)
            ->whereIn('approval_status', ['approved', 'auto_approved'])
            ->first();

        if (!$participation) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Update last read timestamp for user
        $participation->update([
            'last_read_at' => now()
        ]);

        return response()->json(['success' => true]);
    }

    public function getUnreadCount($playTogetherId)
    {
        $playTogether = PlayTogether::findOrFail($playTogetherId);
        $user = Auth::user();

        $participation = $playTogether->participants()
            ->where('user_id', $user->id)
            ->whereIn('approval_status', ['approved', 'auto_approved'])
            ->first();

        if (!$participation) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $lastReadAt = $participation->last_read_at ?? $participation->joined_at;
        
        $unreadCount = $playTogether->chats()
            ->where('created_at', '>', $lastReadAt)
            ->where('user_id', '!=', $user->id) // Exclude own messages
            ->count();

        return response()->json(['unread_count' => $unreadCount]);
    }
}
