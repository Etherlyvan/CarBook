<?php

namespace App\Observers;

use App\Models\Log;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class LogObserver
{
    public function created(Booking $booking)
    {
        Log::create([
            'user_id' => Auth::id(),
            'action' => 'Created booking ID: ' . $booking->id,
        ]);
    }
    // Metode untuk mencatat log ketika booking di-approve
    public function approved(Booking $booking)
    {
        Log::create([
            'user_id' => Auth::id(),
            'action' => 'Approved booking ID: ' . $booking->id,
        ]);
    }

    // Metode untuk mencatat log ketika booking di-reject
    public function rejected(Booking $booking)
    {
        Log::create([
            'user_id' => Auth::id(),
            'action' => 'Rejected booking ID: ' . $booking->id,
        ]);
    }
    
    public function delete(Booking $booking)
    {
        Log::create([
            'user_id' => Auth::id(),
            'action' => 'Deleted booking ID: ' . $booking->id,
        ]);
    }
}
