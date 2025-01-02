@extends('layouts.app')

@section('title', 'Booking Approvals')

@section('content')
    <div class="container-aprove">
        <h1 class="my-4">Booking Approvals</h1>

        @if($message)
            <div class="alert alert-info">
                {{ $message }}
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Vehicle</th>
                            <th>Driver</th>
                            <th>Date</th>
                            <th>Reason</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bookings as $booking)
                            <tr>
                                <td>{{ $booking->vehicle->name }}</td>
                                <td>{{ $booking->requested_by }}</td>
                                <td>{{ $booking->start_date }} > {{ $booking->end_date }}</td>
                                <td>{{ $booking->reason }}</td>
                                <td>
                                    @if($booking->status_level_1 === 'pending')
                                        <form action="{{ route('bookings.approve.level1', $booking->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form action="{{ route('bookings.reject.level1', $booking->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    @endif
                                    @if($booking->status_level_1 === 'approved' && $booking->status_level_2 === 'pending')
                                        <form action="{{ route('bookings.approve.level2', $booking->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                        </form>
                                        <form action="{{ route('bookings.reject.level2', $booking->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
