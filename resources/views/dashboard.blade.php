@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <h1>Dashboard</h1>
    <p>Welcome, {{ auth()->user()->name }}!</p>
    {{-- <div class="stats">
        <p>Total Bookings: {{ $totalBookings }}</p>
        <p>Pending Approvals: {{ $pendingApprovals }}</p>
    </div> --}}
@endsection
