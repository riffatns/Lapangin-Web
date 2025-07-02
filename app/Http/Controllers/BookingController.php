<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user bookings with related data
        $bookings = $user->bookings()
            ->with(['venue.sport', 'payment'])
            ->orderBy('booking_date', 'desc')
            ->get();
        
        // Group bookings by status
        $activeBookings = $bookings->where('status', 'confirmed');
        $pendingBookings = $bookings->where('status', 'pending');
        $completedBookings = $bookings->where('status', 'completed');
        $cancelledBookings = $bookings->where('status', 'cancelled');
        
        return view('pesanan', compact('bookings', 'activeBookings', 'pendingBookings', 'completedBookings', 'cancelledBookings'));
    }
    
    public function cancel(Request $request, $bookingId)
    {
        $booking = Auth::user()->bookings()->findOrFail($bookingId);
        
        if ($booking->status === 'confirmed' || $booking->status === 'pending') {
            $booking->update(['status' => 'cancelled']);
            return redirect()->route('pesanan')->with('success', 'Booking berhasil dibatalkan');
        }
        
        return redirect()->route('pesanan')->with('error', 'Booking tidak dapat dibatalkan');
    }
}
