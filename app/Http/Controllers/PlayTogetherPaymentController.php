<?php

namespace App\Http\Controllers;

use App\Models\PlayTogether;
use App\Models\PlayTogetherPayment;
use App\Models\PlayTogetherParticipant;
use App\Models\PlayTogetherChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PlayTogetherPaymentController extends Controller
{
    public function index($playTogetherId)
    {
        $playTogether = PlayTogether::with(['participants.user', 'organizer'])
            ->findOrFail($playTogetherId);
        
        $user = Auth::user();

        // Check if user is organizer or participant
        $participation = $playTogether->participants()
            ->where('user_id', $user->id)
            ->first();

        $isOrganizer = $playTogether->organizer_id === $user->id;

        if (!$participation && !$isOrganizer) {
            abort(403, 'Unauthorized access');
        }

        $payments = PlayTogetherPayment::where('play_together_id', $playTogetherId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        $paymentSummary = [
            'total_due' => $payments->sum('amount_due'),
            'total_paid' => $payments->where('status', 'completed')->sum('amount_paid'),
            'total_pending' => $payments->where('status', 'pending')->sum('amount_due'),
            'total_overdue' => $payments->where('status', 'overdue')->sum('amount_due'),
            'participants_count' => $payments->count(),
            'paid_count' => $payments->where('status', 'completed')->count(),
            'pending_count' => $payments->where('status', 'pending')->count(),
            'overdue_count' => $payments->where('status', 'overdue')->count()
        ];

        return view('play-together.payments.index', compact(
            'playTogether', 
            'payments', 
            'paymentSummary', 
            'isOrganizer'
        ));
    }

    public function show($playTogetherId, $paymentId)
    {
        $playTogether = PlayTogether::findOrFail($playTogetherId);
        $payment = PlayTogetherPayment::where('play_together_id', $playTogetherId)
            ->with('user')
            ->findOrFail($paymentId);

        $user = Auth::user();

        // Check if user can view this payment
        $canView = $payment->user_id === $user->id || 
                   $playTogether->organizer_id === $user->id;

        if (!$canView) {
            abort(403, 'Unauthorized access');
        }

        return view('play-together.payments.show', compact('playTogether', 'payment'));
    }

    public function markAsPaid(Request $request, $playTogetherId, $paymentId)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:50',
            'payment_reference' => 'nullable|string|max:100',
            'payment_notes' => 'nullable|string|max:500'
        ]);

        $playTogether = PlayTogether::findOrFail($playTogetherId);
        $payment = PlayTogetherPayment::where('play_together_id', $playTogetherId)
            ->findOrFail($paymentId);

        $user = Auth::user();

        // Only payment owner or organizer can mark as paid
        $canMarkPaid = $payment->user_id === $user->id || 
                       $playTogether->organizer_id === $user->id;

        if (!$canMarkPaid) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        DB::beginTransaction();
        try {
            $payment->update([
                'status' => 'completed',
                'amount_paid' => $request->amount_paid,
                'payment_method' => $request->payment_method,
                'payment_reference' => $request->payment_reference,
                'payment_notes' => $request->payment_notes,
                'paid_at' => now(),
                'confirmed_by' => $user->id
            ]);

            // Update participant payment status
            $participant = PlayTogetherParticipant::where('play_together_id', $playTogetherId)
                ->where('user_id', $payment->user_id)
                ->first();

            if ($participant) {
                $participant->update(['payment_completed' => true]);
            }

            // Send system message
            PlayTogetherChat::createSystemMessage(
                $playTogetherId,
                "Pembayaran dari {$payment->user->name} telah dikonfirmasi - Rp " . number_format((float)$request->amount_paid, 0, ',', '.')
            );

            DB::commit();

            return response()->json([
                'success' => true, 
                'message' => 'Pembayaran berhasil dikonfirmasi'
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Gagal mengkonfirmasi pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function uploadProof(Request $request, $playTogetherId, $paymentId)
    {
        $request->validate([
            'proof_image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'payment_notes' => 'nullable|string|max:500'
        ]);

        $playTogether = PlayTogether::findOrFail($playTogetherId);
        $payment = PlayTogetherPayment::where('play_together_id', $playTogetherId)
            ->findOrFail($paymentId);

        $user = Auth::user();

        // Only payment owner can upload proof
        if ($payment->user_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            // Store the uploaded file
            $imagePath = $request->file('proof_image')->store('payment-proofs', 'public');

            $payment->update([
                'status' => 'pending_verification',
                'proof_image' => $imagePath,
                'payment_notes' => $request->payment_notes,
                'proof_uploaded_at' => now()
            ]);

            // Send system message to organizer
            PlayTogetherChat::createSystemMessage(
                $playTogetherId,
                "{$payment->user->name} telah mengupload bukti pembayaran"
            );

            return response()->json([
                'success' => true, 
                'message' => 'Bukti pembayaran berhasil diupload. Menunggu verifikasi organizer.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengupload bukti pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function verifyPayment(Request $request, $playTogetherId, $paymentId)
    {
        $request->validate([
            'action' => 'required|in:approve,reject',
            'verification_notes' => 'nullable|string|max:500'
        ]);

        $playTogether = PlayTogether::findOrFail($playTogetherId);
        $payment = PlayTogetherPayment::where('play_together_id', $playTogetherId)
            ->findOrFail($paymentId);

        $user = Auth::user();

        // Only organizer can verify payments
        if ($playTogether->organizer_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        DB::beginTransaction();
        try {
            if ($request->action === 'approve') {
                $payment->update([
                    'status' => 'completed',
                    'amount_paid' => $payment->amount_due,
                    'paid_at' => now(),
                    'verified_at' => now(),
                    'verified_by' => $user->id,
                    'verification_notes' => $request->verification_notes
                ]);

                // Update participant payment status
                $participant = PlayTogetherParticipant::where('play_together_id', $playTogetherId)
                    ->where('user_id', $payment->user_id)
                    ->first();

                if ($participant) {
                    $participant->update(['payment_completed' => true]);
                }

                PlayTogetherChat::createSystemMessage(
                    $playTogetherId,
                    "Pembayaran {$payment->user->name} telah diverifikasi dan diterima"
                );

                $message = 'Pembayaran berhasil diverifikasi dan diterima';

            } else {
                $payment->update([
                    'status' => 'rejected',
                    'verified_at' => now(),
                    'verified_by' => $user->id,
                    'verification_notes' => $request->verification_notes
                ]);

                PlayTogetherChat::createSystemMessage(
                    $playTogetherId,
                    "Pembayaran {$payment->user->name} ditolak. Silakan upload ulang bukti pembayaran yang benar."
                );

                $message = 'Pembayaran ditolak. Participant akan diminta upload ulang bukti.';
            }

            DB::commit();

            return response()->json([
                'success' => true, 
                'message' => $message
            ]);

        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'error' => 'Gagal memverifikasi pembayaran: ' . $e->getMessage()
            ], 500);
        }
    }

    public function sendReminder(Request $request, $playTogetherId, $paymentId)
    {
        $playTogether = PlayTogether::findOrFail($playTogetherId);
        $payment = PlayTogetherPayment::where('play_together_id', $playTogetherId)
            ->findOrFail($paymentId);

        $user = Auth::user();

        // Only organizer can send reminders
        if ($playTogether->organizer_id !== $user->id) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // Update last reminder sent
        $payment->update([
            'last_reminder_sent' => now()
        ]);

        // Send system message
        PlayTogetherChat::createSystemMessage(
            $playTogetherId,
            "Reminder: {$payment->user->name}, mohon segera lakukan pembayaran sebesar Rp " . 
            number_format((float)$payment->amount_due, 0, ',', '.')
        );

        return response()->json([
            'success' => true, 
            'message' => 'Reminder pembayaran telah dikirim'
        ]);
    }

    public function getPaymentSummary($playTogetherId)
    {
        $playTogether = PlayTogether::findOrFail($playTogetherId);
        $user = Auth::user();

        // Check access
        $participation = $playTogether->participants()->where('user_id', $user->id)->first();
        $isOrganizer = $playTogether->organizer_id === $user->id;

        if (!$participation && !$isOrganizer) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $payments = PlayTogetherPayment::where('play_together_id', $playTogetherId)->get();

        $summary = [
            'total_amount' => $payments->sum('amount_due'),
            'total_paid' => $payments->where('status', 'completed')->sum('amount_paid'),
            'total_pending' => $payments->whereIn('status', ['pending', 'pending_verification'])->sum('amount_due'),
            'total_overdue' => $payments->where('status', 'overdue')->sum('amount_due'),
            'payment_completion_rate' => $payments->count() > 0 ? 
                round(($payments->where('status', 'completed')->count() / $payments->count()) * 100, 1) : 0,
            'participants_paid' => $payments->where('status', 'completed')->count(),
            'participants_pending' => $payments->whereIn('status', ['pending', 'pending_verification'])->count(),
            'participants_overdue' => $payments->where('status', 'overdue')->count()
        ];

        return response()->json(['summary' => $summary]);
    }

    public function payment($playTogetherId)
    {
        $playTogether = PlayTogether::with(['sport', 'venue', 'organizer', 'participants'])
            ->findOrFail($playTogetherId);
        
        $user = Auth::user();

        // Check if user is participant
        $participation = $playTogether->participants()
            ->where('user_id', $user->id)
            ->first();

        if (!$participation) {
            return redirect()->route('play-together.show', $playTogether)
                ->with('error', 'Anda harus bergabung terlebih dahulu untuk melakukan pembayaran.');
        }

        // Check if event requires payment
        if (!$playTogether->price_per_person || $playTogether->price_per_person <= 0) {
            return redirect()->route('play-together.show', $playTogether)
                ->with('error', 'Event ini tidak memerlukan pembayaran.');
        }

        // Calculate payment amount based on payment method
        $paymentAmount = $this->calculatePaymentAmount($playTogether, $user);

        // Get user's payment record
        $userPayment = PlayTogetherPayment::where('play_together_id', $playTogetherId)
            ->where('user_id', $user->id)
            ->first();

        return view('play-together.payment', compact(
            'playTogether', 
            'userPayment', 
            'paymentAmount'
        ));
    }



    public function uploadPaymentProof(Request $request, $playTogetherId)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'notes' => 'nullable|string|max:500'
        ]);

        $playTogether = PlayTogether::findOrFail($playTogetherId);
        $user = Auth::user();

        // Check if user is participant
        $participation = $playTogether->participants()
            ->where('user_id', $user->id)
            ->first();

        if (!$participation) {
            return back()->with('error', 'Anda harus bergabung terlebih dahulu.');
        }

        DB::beginTransaction();
        try {
            // Calculate payment amount
            $paymentAmount = $this->calculatePaymentAmount($playTogether, $user);

            // Store payment proof image
            $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');

            // Create or update payment record
            $userPayment = PlayTogetherPayment::updateOrCreate(
                [
                    'play_together_id' => $playTogetherId,
                    'user_id' => $user->id
                ],
                [
                    'amount_due' => $paymentAmount,
                    'amount_paid' => $paymentAmount,
                    'status' => 'pending_verification',
                    'payment_method' => 'bank_transfer',
                    'proof_image' => $proofPath,
                    'participant_notes' => $request->notes,
                    'paid_at' => now()
                ]
            );

            // Send notification to organizer
            PlayTogetherChat::create([
                'play_together_id' => $playTogetherId,
                'user_id' => null, // System message
                'message' => "{$user->name} telah mengupload bukti pembayaran.",
                'message_type' => 'system'
            ]);

            DB::commit();
            return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu verifikasi organizer.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Gagal mengupload bukti pembayaran: ' . $e->getMessage());
        }
    }

    private function calculatePaymentAmount($playTogether, $user)
    {
        $baseAmount = (float)$playTogether->price_per_person;
        
        switch ($playTogether->payment_method) {
            case 'split_equal':
                // Split total cost equally among all participants
                $totalParticipants = $playTogether->participants->count() + 1; // +1 for organizer
                return (float)$playTogether->total_cost / $totalParticipants;
                
            case 'organizer_pays':
                // Organizer pays everything, participants pay nothing
                return 0;
                
            case 'per_person':
            default:
                // Each person pays the set amount
                return $baseAmount;
        }
    }
}
