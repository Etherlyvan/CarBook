@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<main class="container py-4">
    <div class="row align-items-center">
        <div class="col-lg-8">
            <p class="text-uppercase text-muted small font-weight-bold mb-2">CarBook workspace</p>
            <h1 class="h2 mb-2">Welcome, {{ auth()->user()->name }}</h1>
            <p class="text-muted mb-4">Vehicle requests move through two approval stages before they appear in booking history.</p>
        </div>
        <div class="col-lg-4 text-lg-right mb-4">
            <a class="btn btn-outline-primary" href="{{ route('guide') }}">Open the demo guide</a>
        </div>
    </div>

    <section class="card border-0 shadow-sm">
        <div class="card-body p-4">
            @if (auth()->user()->hasRole('admin'))
                <h2 class="h5">Administrator</h2>
                <p class="text-muted">Create vehicle requests, assign both approvers, and review completed bookings.</p>
                <a class="btn btn-primary" href="{{ route('bookings') }}">Manage bookings</a>
                <a class="btn btn-link" href="{{ route('booking-history.index') }}">View booking history</a>
            @else
                <h2 class="h5">Approver</h2>
                <p class="text-muted">Review requests assigned to you at the current approval stage.</p>
                <a class="btn btn-primary" href="{{ route('bookings.approver') }}">Review approvals</a>
            @endif
        </div>
    </section>
</main>
@endsection
