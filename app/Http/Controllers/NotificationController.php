<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type', 'all');

        $query = $user->notifications()->orderBy('created_at', 'desc');

        if ($type !== 'all') {
            $query->where('type', $type);
        }

        $notifications = $query->paginate(20);

        // Count unread notifications
        $unreadCount = $user->notifications()->where('is_read', false)->count();

        return view('notifikasi', compact('notifications', 'unreadCount', 'type', 'user'));
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id !== Auth::id()) {
            abort(403);
        }

        $notification->markAsRead();

        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        Auth::user()->notifications()
            ->where('is_read', false)
            ->update([
                'is_read' => true,
                'read_at' => now()
            ]);

        return redirect()->back()->with('success', 'Semua notifikasi telah ditandai sebagai dibaca');
    }

    public function createSampleNotifications()
    {
        $user = Auth::user();

        $sampleNotifications = [
            [
                'type' => 'booking',
                'title' => 'Booking Berhasil!',
                'message' => 'Booking lapangan badminton di GOR Badminton Telyu untuk tanggal 15 Januari 2025, pukul 19:00-21:00 telah berhasil dikonfirmasi. Jangan lupa datang tepat waktu dan bawa perlengkapan olahraga Anda!',
                'data' => ['booking_id' => 1],
                'created_at' => now()->subMinutes(2)
            ],
            [
                'type' => 'community',
                'title' => 'Undangan Main Bareng',
                'message' => 'Ahmad Rivaldy mengundang Anda untuk main badminton bersama di Badminton Club Bandung. Waktu: Sabtu, 18 Januari 2025 pukul 16:00. Jangan lewatkan kesempatan main dengan atlet berprestasi!',
                'data' => ['community_id' => 1],
                'created_at' => now()->subHour()
            ],
            [
                'type' => 'promo',
                'title' => 'Diskon 50% Weekend Special!',
                'message' => 'Dapatkan diskon 50% untuk semua booking lapangan tennis di weekend ini! Promo berlaku untuk booking hari Sabtu-Minggu. Gunakan kode: WEEKEND50. Berlaku sampai Minggu, 19 Januari 2025.',
                'data' => ['promo_code' => 'WEEKEND50'],
                'created_at' => now()->subHours(3)
            ],
            [
                'type' => 'achievement',
                'title' => 'Naik Level - Tennis Enthusiast!',
                'message' => 'Selamat! Anda telah mencapai level "Tennis Enthusiast" setelah menyelesaikan 25 match tennis. Anda mendapat 200 poin bonus dan badge baru. Total poin Anda sekarang: 2,650 poin.',
                'data' => ['level' => 'Tennis Enthusiast', 'points' => 200],
                'created_at' => now()->subDay()
            ],
            [
                'type' => 'payment',
                'title' => 'Pembayaran Berhasil',
                'message' => 'Pembayaran sebesar Rp 100.000 untuk booking lapangan futsal di Futsal Arena telah berhasil diproses. Invoice dan e-receipt telah dikirim ke email Anda.',
                'data' => ['payment_id' => 1, 'amount' => 100000],
                'created_at' => now()->subDays(2)
            ]
        ];

        foreach ($sampleNotifications as $notifData) {
            Notification::create([
                'user_id' => $user->id,
                'type' => $notifData['type'],
                'title' => $notifData['title'],
                'message' => $notifData['message'],
                'data' => $notifData['data'],
                'is_read' => false,
                'created_at' => $notifData['created_at']
            ]);
        }

        return response()->json(['success' => true, 'message' => 'Sample notifications created']);
    }
}
