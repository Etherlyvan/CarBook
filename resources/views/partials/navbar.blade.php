<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Application</title>
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .navbar {
            background: none; /* Menghapus latar belakang */
            padding-left: 0; /* Menghapus padding kiri */
            padding-right: 0; /* Menghapus padding kanan */
        }
        .navbar-brand {
            font-size: 1.5rem; /* Mengatur ukuran font */
            font-weight: bold; /* Mengatur ketebalan font */
            color: #343a40; /* Mengatur warna font */
        }
        .nav-link {
            color: #343a40; /* Warna teks default */
        }
        .nav-link:hover {
            color: #000; /* Warna teks saat di-hover */
        }
        .nav-item.active .nav-link {
            color: #000; /* Warna teks saat halaman aktif */
            font-weight: bold; /* Membuat teks lebih tebal pada halaman aktif */
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container nav">
            <span class="navbar-brand">My Application</span>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mr-auto">
                </ul>

                @if(Auth::check())
                    <ul class="navbar-nav ml-auto align-items-center">
                        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                                
                        @if(Auth::user()->hasRole('admin'))
                            <li class="nav-item {{ request()->routeIs('bookings.index') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('bookings') }}">Bookings</a>
                            </li>
                            <li class="nav-item {{ request()->routeIs('bookings.history') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('booking-history.index') }}">History</a>
                            </li>
                        @elseif(Auth::user()->hasRole('approver'))
                            <li class="nav-item {{ request()->routeIs('bookings.approver') ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('bookings.approver') }}">Bookings</a>
                            </li>
                        @endif

                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm ml-2">Logout</button>
                            </form>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav ml-auto align-items-center">
                        <li class="nav-item {{ request()->routeIs('login') ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('login') }}">Login</a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
