@extends('layouts.app')

@section('title', 'Booking History Detail')

@section('content')
    <div class="container">
        <h1 class="my-4">Booking History Detail</h1>

        <div class="card">
            <div class="card-header">
                Booking History ID: {{ $bookingHistory->id }}
            </div>
            <div class="card-body">
                <h5 class="card-title">Vehicle: {{ $bookingHistory->vehicle ? $bookingHistory->vehicle->name : 'N/A' }}</h5>
                <p class="card-text">Booking ID: {{ $bookingHistory->booking ? $bookingHistory->booking->id : 'N/A' }}</p>
                <p class="card-text">Duration: {{ $bookingHistory->duration }} days</p>
                <p class="card-text">Start Date: {{ $bookingHistory->booking ? $bookingHistory->booking->start_date : 'N/A' }}</p>
                <p class="card-text">End Date: {{ $bookingHistory->booking ? $bookingHistory->booking->end_date : 'N/A' }}</p>
                <a href="{{ route('booking-history.index') }}" class="btn btn-primary">Back to List</a>
            </div>
        </div>
    </div>
@endsection
