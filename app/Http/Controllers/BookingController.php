<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\BookingHistory;
use App\Http\Requests\BookingRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Observers\LogObserver;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['vehicle', 'approverLevel1', 'approverLevel2'])->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create()
    {
        // Ambil semua kendaraan yang tersedia
        $vehicles = Vehicle::all();
        $users = User::where('role', '!=', 'admin')->get();
        return view('bookings.create', compact('vehicles', 'users'));
    }

    
    public function getBookedDates($vehicleId)
    {
        $bookedDates = Booking::where('vehicle_id', $vehicleId)
            ->get(['start_date', 'end_date'])
            ->toArray();
    
        $dates = [];
        foreach ($bookedDates as $booking) {
            $period = new \DatePeriod(
                new \DateTime($booking['start_date']),
                new \DateInterval('P1D'),
                (new \DateTime($booking['end_date']))->modify('+1 day')
            );
            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }
        }
    
        return response()->json($dates);
    }
    
    

    public function store(BookingRequest $request)
    {
        Booking::create($request->validated());
        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }
    
    public function edit(Booking $booking)
    {
        $vehicles = Vehicle::all();
        $users = User::all();
        return view('bookings.edit', compact('booking', 'vehicles', 'users'));
    }

    public function update(BookingRequest $request, Booking $booking)
    {
        $booking->update($request->validated());
        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();
        $logObserver = new LogObserver();
        $logObserver->delete($booking);
        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
        
    }

    public function approveLevel1(Request $request, Booking $booking)
    {
        $booking->status_level_1 = 'approved'; // Atur status Level 1 menjadi disetujui
        $booking->approver_level_1 = $request->user()->id; // Simpan ID approver Level 1
        $booking->save();

        $logObserver = new LogObserver();
        $logObserver->approved($booking);
    
        return redirect()->route('bookings.approver')->with('success', 'Booking telah disetujui oleh Level 1.');
    }
    
    public function rejectLevel1($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status_level_1 = 'rejected'; // Tolak level 1
        $booking->save();

         // Panggil metode rejected dari LogObserver
        $logObserver = new LogObserver();
        $logObserver->rejected($booking);
        
        return redirect()->route('bookings.approver')->with('success', 'Booking ditolak oleh Level 1.');
    }
    
    public function approveLevel2($id)
    {
        // Pastikan pengguna terautentikasi
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk melakukan aksi ini.');
        }

        // Temukan booking berdasarkan ID
        $booking = Booking::findOrFail($id);
        
        // Setujui level 2
        $booking->status_level_2 = 'approved';
        $booking->approver_level_2 = Auth::user()->id; // Simpan ID approver Level 2
        $booking->save();

        $logObserver = new LogObserver();
        $logObserver->approved($booking);

        // Check if both levels are approved
        if ($booking->status_level_1 == 'approved' && $booking->status_level_2 == 'approved') {
            $this->createBookingHistory($booking);
        }

        return redirect()->route('bookings.approver')->with('success', 'Booking telah disetujui oleh Level 2.');
    }
    public function rejectLevel2($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->status_level_2 = 'rejected'; // Tolak level 2
        $booking->save();
        
        // Panggil metode rejected dari LogObserver
        $logObserver = new LogObserver();
        $logObserver->rejected($booking);
        return redirect()->route('bookings.approver')->with('success', 'Booking ditolak oleh Level 2.');
    }

    private function createBookingHistory(Booking $booking)
    {
        $startDate = new \DateTime($booking->start_date);
        $endDate = new \DateTime($booking->end_date);
        $duration = $startDate->diff($endDate)->days;

        BookingHistory::create([
            'vehicle_id' => $booking->vehicle_id,
            'booking_id' => $booking->id,
            'duration' => $duration,
        ]);
    }
    
    public function listBookings(Request $request)
    {
        $userId = $request->user()->id;
        $bookings = collect();
        $message = '';

        // Cek apakah pengguna adalah approver
        if ($request->user()->hasRole('approver')) {
            // Cek apakah pengguna adalah approver level 1
            $bookingsLevel1 = Booking::where('approver_level_1', $userId)
                                    ->where('status_level_1', 'pending')
                                    ->get();

            // Cek apakah pengguna adalah approver level 2
            $bookingsLevel2 = Booking::where('status_level_1', 'approved')
                                    ->where('approver_level_2', $userId)
                                    ->where('status_level_2', 'pending')
                                    ->get();

            // Gabungkan booking level 1 dan level 2
            $bookings = $bookingsLevel1->merge($bookingsLevel2);

            // Jika tidak ada booking yang perlu disetujui
            if ($bookings->isEmpty()) {
                $message = 'Tidak ada booking yang perlu disetujui saat ini.';
            }
        } else {
            $message = 'Anda tidak memiliki akses untuk menyetujui booking.';
        }

        return view('bookings.approver', [
            'bookings' => $bookings,
            'message' => $message,
        ]);
    }

    public function updateServiceDate(Request $request)
    {
        $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'last_service_date' => 'required|date',
        ]);

        $vehicle = Vehicle::find($request->vehicle_id);
        $vehicle->last_service_date = $request->last_service_date;
        $vehicle->save();

        return redirect()->back()->with('success', 'Last service date updated successfully.');
    }

    public function history()
    {
        $histories = BookingHistory::with('vehicle', 'booking')->get();

        return view('bookings.history', compact('histories'));
    }
    
    

}
