<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code',
        'user_id',
        'venue_id',
        'booking_date',
        'start_time',
        'end_time',
        'duration_hours',
        'total_price',
        'status',
        'payment_status',
        'notes',
        'confirmed_at',
        'cancelled_at',
        'cancellation_reason',
        'rating',
        'review',
        'selected_time_slots'
    ];

    protected $casts = [
        'booking_date' => 'datetime',
        'total_price' => 'decimal:2',
        'confirmed_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'selected_time_slots' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function venue()
    {
        return $this->belongsTo(Venue::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
    
    /**
     * Get the current status based on time for confirmed bookings
     */
    public function getCurrentStatus()
    {
        // If booking is not confirmed, return original status
        if ($this->status !== 'confirmed') {
            return $this->status;
        }
        
        $now = Carbon::now('Asia/Jakarta');
        $bookingDateTime = $this->getBookingDateTimeInJakarta();
        $endDateTime = $this->getEndDateTimeInJakarta();
        
        // If booking has ended, it should be completed
        if ($now->greaterThan($endDateTime)) {
            return 'completed';
        }
        
        // If booking is currently happening
        if ($now->greaterThanOrEqualTo($bookingDateTime) && $now->lessThanOrEqualTo($endDateTime)) {
            return 'on_going';
        }
        
        // If booking is in the future
        return 'confirmed';
    }
    
    /**
     * Get booking start datetime in Jakarta timezone
     */
    public function getBookingDateTimeInJakarta()
    {
        try {
            // Get date as Y-m-d format
            $dateStr = $this->booking_date->format('Y-m-d');
            
            // Ensure time is in H:i format (remove seconds if present)
            $timeStr = substr($this->start_time, 0, 5);
            
            // Create datetime string
            $datetimeStr = $dateStr . ' ' . $timeStr . ':00';
            
            return Carbon::createFromFormat('Y-m-d H:i:s', $datetimeStr, 'Asia/Jakarta');
        } catch (\Exception $e) {
            // Fallback: parse the date and time separately
            $date = Carbon::parse($this->booking_date)->setTimezone('Asia/Jakarta');
            $time = Carbon::createFromTimeString($this->start_time, 'Asia/Jakarta');
            
            return $date->setTime($time->hour, $time->minute, 0);
        }
    }
    
    /**
     * Get booking end datetime in Jakarta timezone
     */
    public function getEndDateTimeInJakarta()
    {
        try {
            // Get date as Y-m-d format
            $dateStr = $this->booking_date->format('Y-m-d');
            
            // Ensure time is in H:i format (remove seconds if present)
            $timeStr = substr($this->end_time, 0, 5);
            
            // Create datetime string
            $datetimeStr = $dateStr . ' ' . $timeStr . ':00';
            
            return Carbon::createFromFormat('Y-m-d H:i:s', $datetimeStr, 'Asia/Jakarta');
        } catch (\Exception $e) {
            // Fallback: parse the date and time separately
            $date = Carbon::parse($this->booking_date)->setTimezone('Asia/Jakarta');
            $time = Carbon::createFromTimeString($this->end_time, 'Asia/Jakarta');
            
            return $date->setTime($time->hour, $time->minute, 0);
        }
    }
    
    /**
     * Get booking date formatted in Jakarta timezone
     */
    public function getBookingDateFormatted()
    {
        try {
            return Carbon::parse($this->booking_date)->setTimezone('Asia/Jakarta')->format('d M Y');
        } catch (\Exception $e) {
            // Fallback to basic format
            return $this->booking_date->format('d M Y');
        }
    }
    
    /**
     * Get start time formatted in Jakarta timezone
     */
    public function getStartTimeFormatted()
    {
        try {
            // Simply format the time string, removing seconds if present
            $timeStr = substr($this->start_time, 0, 5);
            return $timeStr;
        } catch (\Exception $e) {
            return $this->start_time;
        }
    }
    
    /**
     * Get end time formatted in Jakarta timezone
     */
    public function getEndTimeFormatted()
    {
        try {
            // Simply format the time string, removing seconds if present
            $timeStr = substr($this->end_time, 0, 5);
            return $timeStr;
        } catch (\Exception $e) {
            return $this->end_time;
        }
    }
    
    /**
     * Get time range formatted in Jakarta timezone
     */
    public function getTimeRangeFormatted()
    {
        return $this->getStartTimeFormatted() . ' - ' . $this->getEndTimeFormatted() . ' WIB';
    }
    
    /**
     * Get selected time slots safely (handles null values)
     */
    public function getSelectedTimeSlots()
    {
        if ($this->selected_time_slots && is_array($this->selected_time_slots)) {
            return $this->selected_time_slots;
        }
        
        // Fallback: generate slots from start_time and duration
        $slots = [];
        $startHour = (int) substr($this->start_time, 0, 2);
        for ($i = 0; $i < $this->duration_hours; $i++) {
            $slots[] = sprintf('%02d:00', $startHour + $i);
        }
        
        return $slots;
    }
}
