<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fleet Maintenance')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('styles')
</head>
<body>
    <div class="container-fluid p-0">
        <div class="row g-0">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar">
                <div class="brand">
                    <i class="bi bi-car-front-fill"></i> Fleet
                </div>

                <div class="nav-label">Əsas</div>
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>

                @auth
                    @php
                        $role = Auth::user()->role;
                    @endphp

                    @if($role == 'admin' || $role == 'bus' || $role == 'directorate')
                        <div class="nav-label">İdarəetmə</div>
                        <a href="{{ route('buses.index') }}" class="{{ request()->routeIs('buses.*') ? 'active' : '' }}">
                            <i class="bi bi-bus-front"></i> Avtobuslar
                        </a>
                    @endif

                    @if($role == 'admin' || $role == 'complaint' || $role == 'directorate')
                        <a href="{{ route('complaints.index') }}" class="{{ request()->routeIs('complaints.*') ? 'active' : '' }}">
                            <i class="bi bi-clipboard"></i> Şikayətlər
                        </a>
                    @endif

                    @if($role == 'admin' || $role == 'warehouse' || $role == 'directorate')
                        <a href="{{ route('warehouses.index') }}" class="{{ request()->routeIs('warehouses.*') ? 'active' : '' }}">
                            <i class="bi bi-box-seam"></i> Anbar
                        </a>
                    @endif

                    @if($role == 'directorate')
                        <div class="nav-label text-warning mt-3" style="color:#ffc107 !important;">
                            <i class="bi bi-eye"></i> Yalnız Baxış
                        </div>
                    @endif

                    <hr>
                    <a href="{{ route('profile.edit') }}" class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="bi bi-person"></i> Profil
                    </a>

                    <hr>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100" style="border-radius:10px;">
                            <i class="bi bi-box-arrow-right"></i> Çıxış
                        </button>
                    </form>
                @endauth
            </div>

            <!-- Content -->
            <div class="col-md-10 content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>
