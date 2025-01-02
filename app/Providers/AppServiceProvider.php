<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Booking;
use App\Observers\LogObserver;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Booking::observe(LogObserver::class);
    }
}
