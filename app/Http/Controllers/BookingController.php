<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Booking;
use App\Models\Venue;

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

    public function store(Request $request, Venue $venue)
    {
        $request->validate([
            'booking_date' => 'required|date|after_or_equal:today',
            'selected_slots' => 'required|string',
            'duration' => 'required|integer|min:1',
        ]);

        // Parse selected slots from JSON
        $selectedSlots = json_decode($request->selected_slots, true);
        
        if (empty($selectedSlots)) {
            return redirect()->back()->with('error', 'Silakan pilih minimal satu slot waktu');
        }

        // Validate duration matches selected slots count
        if (count($selectedSlots) != $request->duration) {
            return redirect()->back()->with('error', 'Durasi tidak sesuai dengan jumlah slot yang dipilih');
        }

        // Sort slots to ensure chronological order
        sort($selectedSlots);

        // Get start and end times
        $startTime = $selectedSlots[0];
        $lastSlot = end($selectedSlots);
        $endTime = date('H:i', strtotime($lastSlot . ' + 1 hour'));

        // Check if all slots are available
        foreach ($selectedSlots as $slot) {
            $existingBooking = Booking::where('venue_id', $venue->id)
                ->where('booking_date', $request->booking_date)
                ->where('start_time', '<=', $slot)
                ->where('end_time', '>', $slot)
                ->where('status', '!=', 'cancelled')
                ->first();

            if ($existingBooking) {
                return redirect()->back()->with('error', 'Slot waktu ' . $slot . ' sudah dibooking oleh orang lain');
            }
        }

        // Check for overlapping slots within selected slots (to ensure they are consecutive if needed)
        // For now, we allow non-consecutive slots as per requirements

        // Calculate total price
        $totalPrice = $venue->price_per_hour * count($selectedSlots);

        // Create booking
        $booking = Booking::create([
            'user_id' => auth()->id(),
            'venue_id' => $venue->id,
            'booking_date' => $request->booking_date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'duration_hours' => count($selectedSlots),
            'total_price' => $totalPrice,
            'status' => 'pending',
            'booking_code' => 'LAP-' . strtoupper(uniqid()),
            'selected_time_slots' => json_encode($selectedSlots) // Store selected slots for reference
        ]);

        // Create payment record
        $booking->payment()->create([
            'user_id' => auth()->id(),
            'amount' => $totalPrice,
            'payment_method' => 'pending',
            'status' => 'pending'
        ]);

        return redirect()->route('pesanan')->with('success', 'Booking berhasil dibuat! Silakan lakukan pembayaran.');
    }
}
