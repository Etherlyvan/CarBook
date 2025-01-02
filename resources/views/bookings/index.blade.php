<!-- resources/views/bookings/index.blade.php -->
@extends('layouts.app')

@section('content')

<div style="padding: 20px;">
    <h1 class="mb-4">Booking List</h1>
    <a href="{{ route('bookings.create') }}" class="btn btn-success mb-3">Create New Booking</a>

    @if(isset($message))
        <div class="alert alert-info">
            {{ $message }}
        </div>
    @endif

    <table class="table table-bordered" style="margin-top: 20px; background-color: #fff;">
        <thead class="thead-light">
            <tr>

                <th style="vertical-align: middle; text-align: center; padding: 12px 8px; background-color: #f8f9fa; color: #343a40; font-weight: bold;">Vehicle</th>
                <th style="vertical-align: middle; text-align: center; padding: 12px 8px; background-color: #f8f9fa; color: #343a40; font-weight: bold;">Requested By</th>
                <th style="vertical-align: middle; text-align: center; padding: 12px 8px; background-color: #f8f9fa; color: #343a40; font-weight: bold;">Approver 1</th>
                <th style="vertical-align: middle; text-align: center; padding: 12px 8px; background-color: #f8f9fa; color: #343a40; font-weight: bold;">Status</th>
                <th style="vertical-align: middle; text-align: center; padding: 12px 8px; background-color: #f8f9fa; color: #343a40; font-weight: bold;">Approver 2</th>
                <th style="vertical-align: middle; text-align: center; padding: 12px 8px; background-color: #f8f9fa; color: #343a40; font-weight: bold;">Status</th>
                <th style="vertical-align: middle; text-align: center; padding: 12px 8px; background-color: #f8f9fa; color: #343a40; font-weight: bold;">Start Date</th>
                <th style="vertical-align: middle; text-align: center; padding: 12px 8px; background-color: #f8f9fa; color: #343a40; font-weight: bold;">End Date</th>
                <th style="vertical-align: middle; text-align: center; padding: 12px 8px; background-color: #f8f9fa; color: #343a40; font-weight: bold;">Reason</th>
                <th style="vertical-align: middle; text-align: center; padding: 12px 8px; background-color: #f8f9fa; color: #343a40; font-weight: bold;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($bookings->isEmpty())
                <tr>
                    <td colspan="11" class="text-center" style="padding: 12px 8px;">Tidak ada booking yang ditemukan.</td>
                </tr>
            @else
                @foreach($bookings as $booking)
                    <tr style="background-color: #fff; border: 1px solid #dee2e6;">

                        <td style="vertical-align: middle; text-align: center; padding: 12px 8px;">{{ $booking->vehicle->name }}</td>
                        <td style="vertical-align: middle; text-align: center; padding: 12px 8px;">{{ $booking->requested_by }}</td>
                        <td style="vertical-align: middle; text-align: center; padding: 12px 8px;">{{ $booking->approverLevel1->name }}</td>
                        <td style="vertical-align: middle; text-align: center; padding: 12px 8px;">{{ ucfirst($booking->status_level_1) }}</td>
                        <td style="vertical-align: middle; text-align: center; padding: 12px 8px;">{{ $booking->approverLevel2->name }}</td>
                        <td style="vertical-align: middle; text-align: center; padding: 12px 8px;">{{ ucfirst($booking->status_level_2) }}</td>
                        <td style="vertical-align: middle; text-align: center; padding: 12px 8px;">{{ $booking->start_date }}</td>
                        <td style="vertical-align: middle; text-align: center; padding: 12px 8px;">{{ $booking->end_date }}</td>
                        <td style="vertical-align: middle; text-align: center; padding: 12px 8px;">{{ $booking->reason }}</td>
                        <td style="vertical-align: middle; text-align: center; padding: 12px 8px;">
                            <form action="{{ route('bookings.destroy', $booking->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" style="margin-right: 5px;">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
@endsection
