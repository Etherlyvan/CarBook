<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $table = 'bookings'; // Nama tabel jika berbeda dari konvensi

    protected $fillable = [
        'vehicle_id',
        'requested_by',
        'approver_level_1',
        'status_level_1',
        'approver_level_2',
        'status_level_2',
        'start_date',
        'end_date',
        'reason',
    ];
    
    public function bookingHistories()
    {
        return $this->hasMany(BookingHistory::class);
    }


    // Definisi relasi
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function approverLevel1()
    {
        return $this->belongsTo(User::class, 'approver_level_1');
    }

    public function approverLevel2()
    {
        return $this->belongsTo(User::class, 'approver_level_2');
    }
}
