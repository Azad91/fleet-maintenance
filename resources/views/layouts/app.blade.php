<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Fleet Maintenance')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #f4f6f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        .sidebar {
            min-height: 100vh;
            background: linear-gradient(180deg, #1a1a2e 0%, #16213e 100%);
            padding-top: 20px;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }
        .sidebar .brand {
            color: white;
            font-size: 24px;
            font-weight: 700;
            padding: 15px 25px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 15px;
            letter-spacing: 0.5px;
        }
        .sidebar .brand i { color: #4CAF50; margin-right: 10px; }
        .sidebar a {
            color: #aaa;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 25px;
            transition: all 0.3s ease;
            border-radius: 10px;
            margin: 4px 12px;
            font-size: 15px;
        }
        .sidebar a:hover {
            background: rgba(255,255,255,0.08);
            color: white;
            transform: translateX(5px);
        }
        .sidebar a.active {
            background: #4CAF50;
            color: white;
            box-shadow: 0 4px 15px rgba(76, 175, 80, 0.3);
        }
        .sidebar a i { font-size: 20px; width: 24px; text-align: center; }
        .sidebar hr { border-color: rgba(255,255,255,0.08); margin: 15px 12px; }
        .sidebar .nav-label {
            color: #666;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 10px 25px 5px;
            font-weight: 600;
        }

        .content {
            padding: 30px;
            min-height: 100vh;
            background: #f4f6f9;
        }

        .card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 2px 15px rgba(0,0,0,0.06);
            transition: all 0.3s ease;
            background: white;
        }
        .card:hover { box-shadow: 0 4px 25px rgba(0,0,0,0.1); }
        .card-header {
            background: transparent;
            border-bottom: 1px solid #eee;
            padding: 18px 25px;
            font-weight: 600;
            font-size: 16px;
        }
        .card-body { padding: 25px; }

        .stat-card {
            padding: 25px;
            border-radius: 16px;
            color: white;
            border: none;
            transition: transform 0.3s ease;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-card .icon { font-size: 35px; opacity: 0.7; }
        .stat-card .count { font-size: 30px; font-weight: 700; }
        .stat-card .label { font-size: 14px; opacity: 0.9; margin-top: 2px; }

        .bg-primary-gradient { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
        .bg-success-gradient { background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); }
        .bg-warning-gradient { background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); }
        .bg-info-gradient { background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); }

        .table th {
            background: #f8f9fa;
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            color: #555;
            border-bottom: 2px solid #dee2e6;
            padding: 12px 15px;
        }
        .table td {
            vertical-align: middle;
            padding: 12px 15px;
            font-size: 14px;
        }
        .table-hover tbody tr:hover { background: #f8f9fa; }

        .badge-status {
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
        .badge-status.gözləmədə { background: #ffc107; color: #000; }
        .badge-status.işdə { background: #0d6efd; color: #fff; }
        .badge-status.həll-olundu { background: #198754; color: #fff; }
        .badge-status.aktiv { background: #198754; color: #fff; }
        .badge-status.passiv { background: #dc3545; color: #fff; }
        .badge-status.temir { background: #ffc107; color: #000; }

        .btn-sm { padding: 5px 10px; font-size: 13px; border-radius: 8px; }
        .btn-action { display: inline-flex; align-items: center; gap: 5px; }

        .alert { border-radius: 12px; border: none; padding: 15px 20px; }
        .alert-success { background: #d4edda; color: #155724; }
        .alert-danger { background: #f8d7da; color: #721c24; }
        .alert-info { background: #d1ecf1; color: #0c5460; }

        .input-group-text { background: #f8f9fa; border: 1px solid #dee2e6; }
        .form-control, .form-select {
            border-radius: 10px;
            border: 1px solid #dee2e6;
            padding: 10px 15px;
            font-size: 14px;
        }
        .form-control:focus, .form-select:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
        }

        .btn { border-radius: 10px; padding: 10px 20px; font-weight: 500; }
        .btn-primary { background: #4CAF50; border-color: #4CAF50; }
        .btn-primary:hover { background: #43a047; border-color: #43a047; }
        .btn-success { background: #28a745; border-color: #28a745; }
        .btn-success:hover { background: #218838; border-color: #218838; }
        .btn-warning { background: #ffc107; border-color: #ffc107; color: #000; }
        .btn-warning:hover { background: #e0a800; border-color: #e0a800; }
        .btn-danger { background: #dc3545; border-color: #dc3545; }
        .btn-danger:hover { background: #c82333; border-color: #c82333; }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f2f5;
        }
        .section-title .badge {
            background: #4CAF50;
            color: white;
            padding: 3px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-left: 10px;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .sidebar { min-height: auto; height: auto; position: relative; }
            .content { padding: 15px; }
            .stat-card .count { font-size: 22px; }
        }

        .text-muted { color: #6c757d !important; }
        .text-danger { color: #dc3545 !important; }
        .text-warning { color: #ffc107 !important; }
        .text-success { color: #28a745 !important; }

        .gap-1 { gap: 5px; }
        .gap-2 { gap: 10px; }
        .gap-3 { gap: 15px; }

        .fw-bold { font-weight: 700; }
        .fw-semibold { font-weight: 600; }
    </style>
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

                <div class="nav-label">İdarəetmə</div>
                <a href="{{ route('buses.index') }}" class="{{ request()->routeIs('buses.*') ? 'active' : '' }}">
                    <i class="bi bi-bus-front"></i> Avtobuslar
                </a>
                <a href="{{ route('complaints.index') }}" class="{{ request()->routeIs('complaints.*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard"></i> Şikayətlər
                </a>
                <a href="{{ route('warehouses.index') }}" class="{{ request()->routeIs('warehouses.*') ? 'active' : '' }}">
                    <i class="bi bi-box-seam"></i> Anbar
                </a>

                <hr>
                <a href="{{ url('/') }}" style="color:#666;">
                    <i class="bi bi-house"></i> Ana Səhifə
                </a>
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
