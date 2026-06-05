<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library System - @yield('title')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Custom CSS Overrides -->
    <style>
        :root {
            --primary: #0f172a;
            --primary-soft: #1e293b;
            --accent: #10b981;
            --accent-hover: #059669;
            --bg-body: #f8fafc;
            --card-border: rgba(241, 245, 249, 1);
            --text-dark: #0f172a;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-dark);
            -webkit-font-smoothing: antialiased;
        }

        /* Top Navbar Customization */
        .navbar-custom {
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            padding: 0.75rem 1.5rem;
        }

        .navbar-custom .navbar-brand {
            color: var(--primary);
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-custom .navbar-brand i {
            color: var(--accent);
        }

        .navbar-custom .nav-link {
            color: var(--text-muted);
            font-weight: 500;
            transition: color 0.2s ease;
        }

        .navbar-custom .nav-link:hover {
            color: var(--accent);
        }

        /* Sidebar Styling */
        .sidebar {
            min-height: calc(100vh - 65px);
            background-color: var(--primary);
            color: #ffffff;
            padding: 1.5rem 1rem;
            border-right: 1px solid var(--primary-soft);
        }

        .sidebar .list-group-item {
            background-color: transparent;
            color: #94a3b8;
            border: none;
            border-radius: 0.75rem;
            margin-bottom: 0.5rem;
            padding: 0.75rem 1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.2s ease;
        }

        .sidebar .list-group-item i {
            font-size: 1.1rem;
            width: 24px;
            color: #64748b;
            transition: color 0.2s ease;
        }

        .sidebar .list-group-item:hover {
            background-color: var(--primary-soft);
            color: #ffffff;
        }

        .sidebar .list-group-item:hover i {
            color: var(--accent);
        }

        .sidebar .list-group-item.active {
            background-color: var(--accent);
            color: var(--primary);
            font-weight: 600;
        }

        .sidebar .list-group-item.active i {
            color: var(--primary);
        }

        /* Content Area */
        .content-wrapper {
            padding: 2.25rem 2rem;
        }

        /* Premium Card Styles */
        .card {
            border: 1px solid var(--card-border);
            border-radius: 1.25rem;
            box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.04);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            background: #ffffff;
            overflow: hidden;
        }

        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            padding: 1.25rem 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        /* Buttons Redesign */
        .btn-primary {
            background-color: var(--accent);
            border-color: var(--accent);
            color: var(--primary);
            font-weight: 600;
            border-radius: 0.75rem;
            padding: 0.5rem 1.25rem;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.15);
        }

        .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
            background-color: var(--accent-hover) !important;
            border-color: var(--accent-hover) !important;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(16, 185, 129, 0.25);
        }

        .btn-secondary {
            border-radius: 0.75rem;
            font-weight: 600;
            padding: 0.5rem 1.25rem;
        }

        .btn-warning {
            border-radius: 0.75rem;
            font-weight: 600;
            color: #ffffff !important;
        }

        .btn-danger {
            border-radius: 0.75rem;
            font-weight: 600;
        }

        .btn-success {
            border-radius: 0.75rem;
            font-weight: 600;
            padding: 0.5rem 1.25rem;
        }

        /* Forms Styling */
        .form-control, .form-select {
            border-radius: 0.75rem;
            border: 1px solid #cbd5e1;
            padding: 0.625rem 1rem;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
        }

        /* Table Aesthetics */
        .table {
            color: var(--primary);
        }

        .table > :not(caption) > * > * {
            padding: 1rem 1.25rem;
            vertical-align: middle;
            border-bottom-color: #f1f5f9;
        }

        .table-light {
            background-color: #f8fafc;
        }

        .table-light th {
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.05em;
        }

        /* Soft Badges */
        .badge {
            font-weight: 600;
            padding: 0.35em 0.8em;
            border-radius: 0.5rem;
            font-size: 0.75rem;
        }

        .bg-success {
            background-color: #ecfdf5 !important;
            color: #047857 !important;
        }

        .bg-danger {
            background-color: #fef2f2 !important;
            color: #b91c1c !important;
        }

        .bg-warning {
            background-color: #fffbeb !important;
            color: #b45309 !important;
        }

        .bg-info {
            background-color: #eff6ff !important;
            color: #1d4ed8 !important;
        }

        /* Alerts Customization */
        .alert {
            border-radius: 0.75rem;
            border: none;
            padding: 1rem 1.25rem;
        }

        .alert-success {
            background-color: #ecfdf5;
            color: #065f46;
        }

        .alert-danger {
            background-color: #fef2f2;
            color: #991b1b;
        }

        /* Footer */
        footer {
            background-color: #ffffff !important;
            border-top: 1px solid #f1f5f9;
            color: var(--text-muted) !important;
        }
    </style>
    @yield('styles')
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light navbar-custom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="fas fa-book-open"></i>PustakaDigital
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @auth
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('books.*') ? 'active' : '' }}" href="{{ route('books.index') }}">Buku</a>
                    </li>
                    @if(auth()->user()->role == 'admin')
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('members.*') ? 'active' : '' }}" href="{{ route('members.index') }}">Anggota</a>
                    </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('borrowings.*') && !request()->routeIs('borrowings.history') ? 'active' : '' }}" href="{{ route('borrowings.index') }}">Peminjaman</a>
                    </li>
                    @endauth
                </ul>
                <ul class="navbar-nav">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                    </li>
                    @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <div class="h-8 w-8 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-800 font-semibold" style="width: 32px; height: 32px; font-size: 0.85rem;">
                                {{ substr(Auth::user()->name, 0, 2) }}
                            </div>
                            <span class="fw-semibold text-dark">{{ Auth::user()->full_name ?? Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2" style="border-radius: 0.75rem;">
                            <li><span class="dropdown-header">Peran: {{ ucfirst(Auth::user()->role) }}</span></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger d-flex align-items-center gap-2">
                                        <i class="fas fa-sign-out-alt"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            @auth
            <!-- Sidebar (only for authenticated users) -->
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                <div class="list-group">
                    <a href="{{ route('dashboard') }}" class="list-group-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a href="{{ route('books.index') }}" class="list-group-item {{ request()->routeIs('books.*') ? 'active' : '' }}">
                        <i class="fas fa-book me-2"></i>Buku
                    </a>
                    @if(auth()->user()->role == 'admin')
                    <a href="{{ route('members.index') }}" class="list-group-item {{ request()->routeIs('members.*') ? 'active' : '' }}">
                        <i class="fas fa-users me-2"></i>Anggota
                    </a>
                    @endif
                    <a href="{{ route('borrowings.index') }}" class="list-group-item {{ request()->routeIs('borrowings.*') && !request()->routeIs('borrowings.history') ? 'active' : '' }}">
                        <i class="fas fa-exchange-alt me-2"></i>Peminjaman
                    </a>
                    @if(auth()->user()->role == 'member')
                    <a href="{{ route('borrowings.history') }}" class="list-group-item {{ request()->routeIs('borrowings.history') ? 'active' : '' }}">
                        <i class="fas fa-history me-2"></i>Riwayat Saya
                    </a>
                    @endif
                </div>
            </div>
            <!-- Main Content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 content-wrapper">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-4 border-bottom">
                    <h1 class="h2 fw-bold text-slate-800">@yield('page-title')</h1>
                    <div class="btn-toolbar mb-2 mb-md-0">
                        @yield('page-actions')
                    </div>
                </div>

                @yield('content')
                {{ $slot ?? '' }}
            </main>
            @else
            <!-- Content for non-authenticated users -->
            <main class="col-12 px-5 py-4">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @yield('content')
                {{ $slot ?? '' }}
            </main>
            @endauth
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 mt-auto">
        <div class="container">
            <p class="mb-0 text-slate-500">PustakaDigital &copy; {{ date('Y') }} - Sistem Manajemen Perpustakaan</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Optional JavaScript -->
    @yield('scripts')
</body>

</html>