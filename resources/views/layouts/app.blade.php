<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - Bank Sampah</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #ffffff;
            box-shadow: 0 2px 4px rgba(0,0,0,.08);
        }
        .card {
            border: none;
            box-shadow: 0 0.125rem 0.25rem rgba(0,0,0,.075);
            transition: transform 0.2s;
        }
        .card:hover {
            transform: translateY(-2px);
        }
        .bg-gradient-primary {
            background: linear-gradient(45deg, #4e73df 0%, #224abe 100%);
        }
        .bg-gradient-success {
            background: linear-gradient(45deg, #1cc88a 0%, #13855c 100%);
        }
        .bg-gradient-warning {
            background: linear-gradient(45deg, #f6c23e 0%, #dda20a 100%);
        }
        .breadcrumb {
            background-color: transparent;
            padding: 0;
            margin-bottom: 1.5rem;
        }
        .breadcrumb-item a {
            color: #4e73df;
            text-decoration: none;
        }
        .breadcrumb-item.active {
            color: #858796;
        }
        .nav-link {
            color: #5a5c69;
            font-weight: 500;
        }
        .nav-link:hover, .nav-link.active {
            color: #4e73df;
        }
        .btn-primary {
            background-color: #4e73df;
            border-color: #4e73df;
        }
        .btn-primary:hover {
            background-color: #224abe;
            border-color: #224abe;
        }
        .table {
            background-color: #ffffff;
        }
        .table thead th {
            background-color: #f8f9fc;
            border-bottom: 2px solid #e3e6f0;
        }
    </style>
    @stack('styles')
</head>
<body class="d-flex flex-column min-vh-100">
    <header>
        <nav class="navbar navbar-expand-lg sticky-top">
            <div class="container">
                <a class="navbar-brand" href="{{ route('dashboard') }}">
                    <i class="fas fa-recycle me-2"></i>Bank Sampah
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    @auth
                        <ul class="navbar-nav me-auto">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                                   href="{{ route('dashboard') }}">
                                   <i class="fas fa-home me-2"></i>Dashboard
                                </a>
                            </li>
                            @if(auth()->user()->isAdmin())
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.sampah.*') ? 'active' : '' }}" 
                                       href="{{ route('admin.sampah.index') }}">
                                       <i class="fas fa-trash me-2"></i>Kelola Sampah
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                                       href="{{ route('admin.users.index') }}">
                                       <i class="fas fa-users me-2"></i>Kelola Users
                                    </a>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('sampah.*') ? 'active' : '' }}" 
                                       href="{{ route('sampah.index') }}">
                                       <i class="fas fa-trash me-2"></i>Input Sampah
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('redeem.*') ? 'active' : '' }}" 
                                       href="{{ route('redeem.index') }}">
                                       <i class="fas fa-gift me-2"></i>Redeem Poin
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link {{ request()->routeIs('barang-bekas.*') ? 'active' : '' }}" 
                                       href="{{ route('barang-bekas.index') }}">
                                       <i class="fas fa-store me-2"></i>Barang Bekas
                                    </a>
                                </li>
                            @endif
                        </ul>
                        <ul class="navbar-nav">
                            @if(!auth()->user()->isAdmin())
                            <li class="nav-item me-3">
                                <span class="nav-link">
                                    <i class="fas fa-coins text-warning"></i>
                                    <span class="badge bg-warning text-dark">{{ number_format(auth()->user()->total_poin) }} Poin</span>
                                    <span class="badge bg-light text-dark">{{ ucfirst(auth()->user()->level) }}</span>
                                </span>
                            </li>
                            @endif
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            <i class="fas fa-user me-2"></i>Profile
                                        </a>
                                    </li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <main class="flex-grow-1 py-4">
        @if(session('success'))
            <div class="container">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-light py-3 mt-auto">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Bank Sampah. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html> 