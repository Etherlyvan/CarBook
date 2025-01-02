<?php
namespace App\Http\Controllers;
use App\Models\BookingHistory;
use Illuminate\Http\Request;

class BookingHistoryController extends Controller
{
    public function index()
    {
        $histories = BookingHistory::with('vehicle', 'booking')->get();
        return view('booking-history.index', compact('histories'));
    }
    
    public function show($id)
    {
        $bookingHistory=BookingHistory::with('vehicle', 'booking')
        ->get()
        ->findOrFail($id);
        return view('booking-history.show', compact('bookingHistory'));
    }
}
