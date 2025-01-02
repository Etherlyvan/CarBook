@extends('layouts.app')

@section('title', 'Booking History')

@section('content')
    <div class="container">
        <h1 class="my-4">Booking History</h1>

        <div class="table-responsive">
            @if($histories->isEmpty())
                <div class="alert alert-info" role="alert">
                    No booking history available.
                </div>
            @else
                <table class="table table-striped table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Vehicle</th>
                            <th>Driver</th>
                            <th>Duration (days)</th>
                            <th>Aprover 1</th>
                            <th>Aprover 2</th>
                            <th>Start</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($histories as $history)
                            <tr>
                                <td>{{ $history->vehicle->name  }}</td>
                                <td>{{ $history->booking->requested_by }}</td>
                                <td>{{ $history->duration}}</td>
                                <td>{{ $history->booking->approverLevel1->name }}</td>
                                <td>{{ $history->booking->approverLevel2->name }}</td>
                                <td>{{ $history->booking->start_date }}</td>
                                <td>
                                    <a href="{{ route('booking-history.show', $history->id) }}" class="btn btn-primary btn-sm">View</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
