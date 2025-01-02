<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'is_company_owned',
        'fuel_consumption',
        'last_service_date',
    ];
    public function bookingHistories()
    {
        return $this->hasMany(BookingHistory::class);
    }
}
