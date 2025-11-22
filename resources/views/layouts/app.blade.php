<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistema de Consejería UPT')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @stack('styles')
    
    <style>
        :root {
            --upt-primary: #003366;
            --upt-secondary: #0066cc;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .navbar-brand {
            font-weight: bold;
            color: var(--upt-primary) !important;
        }
        
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #f8f9fa;
            border-right: 1px solid #dee2e6;
        }
        
        .sidebar .nav-link {
            color: #495057;
            padding: 0.75rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
        }
        
        .sidebar .nav-link:hover {
            background-color: #e9ecef;
            color: var(--upt-primary);
        }
        
        .sidebar .nav-link.active {
            background-color: var(--upt-primary);
            color: white;
        }
        
        .btn-primary {
            background-color: var(--upt-primary);
            border-color: var(--upt-primary);
        }
        
        .btn-primary:hover {
            background-color: var(--upt-secondary);
            border-color: var(--upt-secondary);
        }
        
        .card-header {
            background-color: var(--upt-primary);
            color: white;
        }
    </style>
</head>
<body>
    @if(Session::has('docente_data'))
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('dashboard') }}">
                <i class="fas fa-graduation-cap"></i> Sistema de Consejería UPT
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i> {{ Session::get('docente_data')->nombres }} {{ Session::get('docente_data')->apellidos }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar p-3">
                <div class="position-sticky">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('atenciones.*') ? 'active' : '' }}" href="{{ route('atenciones.index') }}">
                                <i class="fas fa-clipboard-list"></i> Atenciones
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('reportes.*') ? 'active' : '' }}" href="{{ route('reportes.index') }}">
                                <i class="fas fa-chart-bar"></i> Reportes
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
    @else
        @yield('content')
    @endauth

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
