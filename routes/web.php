<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingHistoryController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRole;

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute untuk admin
    Route::middleware('role:admin')->group(function () {
        Route::post('/vehicles/updateServiceDate', [BookingController::class, 'updateServiceDate'])->name('vehicles.updateServiceDate');

        Route::post('/bookings', [BookingController::class, 'store'])
        ->name('bookings.store');
        Route::resource('bookings', BookingController::class);
        Route::get('/bookings/booked-dates/{vehicle}', [BookingController::class, 'getBookedDates'])->name('bookings.booked-dates');

        Route::get('bookings', [BookingController::class, 'index'])
        ->name('bookings');

        Route::get('/booking-history/index', [BookingHistoryController::class, 'index'])->name('booking-history.index');
        Route::get('/booking-history/{id}', [BookingHistoryController::class, 'show'])->name('booking-history.show');
            
    });

    // Rute untuk approver
    Route::middleware(['role:approver'])->group(function () {
        Route::get('bookings.approver', [BookingController::class, 'listBookings'])
            ->name('bookings.approver');
    
        Route::post('bookings/{booking}/approve-level-1', [BookingController::class, 'approveLevel1'])
            ->name('bookings.approve.level1');
    
        Route::post('bookings/{booking}/reject-level-1', [BookingController::class, 'rejectLevel1'])
            ->name('bookings.reject.level1');
    
        Route::post('bookings/{booking}/approve-level-2', [BookingController::class, 'approveLevel2'])
            ->name('bookings.approve.level2');
    
        Route::post('bookings/{booking}/reject-level-2', [BookingController::class, 'rejectLevel2'])
            ->name('bookings.reject.level2');
    });

    // Rute ekspor
    Route::get('/export', [ExportController::class, 'export'])
        ->name('export')
        ->middleware('role:admin');
});
