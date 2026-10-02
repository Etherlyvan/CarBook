<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="{{ route('home') }}">CarBook</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#carbook-navigation" aria-controls="carbook-navigation" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="carbook-navigation">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item {{ request()->routeIs('guide') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('guide') }}">Demo guide</a>
                </li>
                @if (Auth::check())
                    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    @if (Auth::user()->hasRole('admin'))
                        <li class="nav-item {{ request()->routeIs('bookings.*') || request()->routeIs('bookings') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('bookings') }}">Bookings</a>
                        </li>
                        <li class="nav-item {{ request()->routeIs('booking-history.*') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('booking-history.index') }}">History</a>
                        </li>
                    @elseif (Auth::user()->hasRole('approver'))
                        <li class="nav-item {{ request()->routeIs('bookings.approver') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('bookings.approver') }}">Approvals</a>
                        </li>
                    @endif
                @endif
            </ul>

            @if (Auth::check())
                <span class="navbar-text mr-3">{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="form-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-secondary btn-sm">Sign out</button>
                </form>
            @else
                <a class="btn btn-primary btn-sm" href="{{ route('login') }}">Sign in</a>
            @endif
        </div>
    </div>
</nav>
