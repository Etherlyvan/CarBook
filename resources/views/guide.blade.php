@extends('layouts.app')

@section('title', 'CarBook demo guide')

@section('content')
<style>
    .guide-page { max-width: 1040px; margin: 2rem auto 4rem; color: #172033; }
    .guide-hero { padding: 2.5rem; border-radius: 1.25rem; color: #fff; background: linear-gradient(125deg, #14233b, #245a67); }
    .guide-kicker { color: #a9e6d2; font-size: .78rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; }
    .guide-hero h1 { max-width: 680px; margin: .7rem 0; font-size: clamp(2rem, 5vw, 3.2rem); font-weight: 750; line-height: 1.08; }
    .guide-hero p { max-width: 650px; margin-bottom: 1.35rem; color: #d9e4ed; font-size: 1.05rem; }
    .guide-action { display: inline-block; padding: .7rem 1rem; border-radius: .55rem; background: #a9e6d2; color: #14233b; font-weight: 700; text-decoration: none; }
    .guide-action:hover { background: #c0f1e2; color: #14233b; text-decoration: none; }
    .guide-heading { margin: 2.2rem 0 1rem; font-size: 1.45rem; font-weight: 700; }
    .guide-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; }
    .guide-card { padding: 1.25rem; border: 1px solid #e2e8f0; border-radius: .9rem; background: #fff; box-shadow: 0 8px 24px rgba(23, 32, 51, .045); }
    .guide-number { display: inline-grid; width: 2rem; height: 2rem; margin-bottom: .8rem; place-items: center; border-radius: 50%; background: #e4f5ef; color: #17604d; font-weight: 750; }
    .guide-card h3 { font-size: 1.05rem; font-weight: 700; }
    .guide-card p, .guide-note { color: #5b6677; }
    .guide-role { display: inline-block; margin: .1rem 0 .55rem; padding: .2rem .55rem; border-radius: 99px; background: #eef2f7; color: #34445b; font-size: .76rem; font-weight: 700; }
    .guide-note { margin-top: 1rem; padding: 1rem 1.1rem; border-left: 4px solid #3a9a7a; border-radius: .35rem; background: #f1faf6; }
    .guide-credentials { padding: 1.25rem; border: 1px dashed #8ebdad; border-radius: .9rem; background: #f7fcf9; }
    .guide-credentials code { color: #17604d; }
    @media (max-width: 576px) { .guide-page { margin-top: 1rem; } .guide-hero { padding: 1.5rem; } }
</style>

<main class="guide-page">
    <section class="guide-hero">
        <div class="guide-kicker">CarBook · guided demo</div>
        <h1>See how a vehicle request moves from submission to approval.</h1>
        <p>Follow one booking through the admin workflow and both approval stages. The guide works as a walkthrough while you use the app.</p>
        <a class="guide-action" href="{{ route('login') }}">Start at sign in <span aria-hidden="true">→</span></a>
    </section>

    <h2 class="guide-heading">The four-step walkthrough</h2>
    <section class="guide-grid" aria-label="Demo steps">
        <article class="guide-card">
            <span class="guide-number">1</span>
            <div class="guide-role">Admin</div>
            <h3>Create a request</h3>
            <p>Open <strong>Bookings</strong>, choose <strong>Create New Booking</strong>, then select a vehicle, requester, two different approvers, dates, and a reason.</p>
        </article>
        <article class="guide-card">
            <span class="guide-number">2</span>
            <div class="guide-role">Approver · stage 1</div>
            <h3>Review the request</h3>
            <p>Sign out and sign in as the first approver. Open <strong>Bookings</strong> and approve or reject the request assigned to you.</p>
        </article>
        <article class="guide-card">
            <span class="guide-number">3</span>
            <div class="guide-role">Approver · stage 2</div>
            <h3>Complete the approval</h3>
            <p>After stage 1 approves, sign in as the second approver. The request appears in your queue for the final decision.</p>
        </article>
        <article class="guide-card">
            <span class="guide-number">4</span>
            <div class="guide-role">Admin</div>
            <h3>Review booking history</h3>
            <p>Sign back in as admin and open <strong>History</strong>. Fully approved requests are recorded there with their booking duration.</p>
        </article>
    </section>

    <h2 class="guide-heading">What each role can do</h2>
    <section class="guide-grid" aria-label="Role capabilities">
        <article class="guide-card">
            <h3>Administrator</h3>
            <p>Create and manage requests, assign approvers, update vehicle service dates, and view booking history.</p>
        </article>
        <article class="guide-card">
            <h3>Approver</h3>
            <p>Review only the requests assigned to you at the current approval stage, then approve or reject them.</p>
        </article>
    </section>

    @if (app()->environment('local', 'testing'))
        <h2 class="guide-heading">Local demo sign-ins</h2>
        <section class="guide-credentials">
            <p class="mb-2">These accounts are created by the local database seeder. Each uses the password <code>password</code>.</p>
            <ul class="mb-0">
                <li>Admin: <code>admin@example.com</code></li>
                <li>First approver: <code>approver@example.com</code></li>
                <li>Second approver: <code>approver2@example.com</code></li>
            </ul>
        </section>
    @else
        <div class="guide-note"><strong>Production:</strong> demo accounts are not created automatically. Create accounts with <code>php artisan app:create-user admin</code> or <code>php artisan app:create-user approver</code> after deploying and migrating.</div>
    @endif

    <div class="guide-note"><strong>Tip:</strong> choose future dates and two different approvers so the request can pass cleanly through both stages.</div>
</main>
@endsection
