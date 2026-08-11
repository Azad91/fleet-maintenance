<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Qeydiyyat - Fleet Maintenance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .auth-container {
            max-width: 450px;
            width: 100%;
            padding: 20px;
        }
        .card-auth {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 40px 35px;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
        }
        .logo {
            font-size: 40px;
            color: #4CAF50;
            text-align: center;
            margin-bottom: 5px;
        }
        .auth-title {
            color: #fff;
            font-size: 26px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 5px;
        }
        .auth-title span {
            color: #4CAF50;
        }
        .auth-subtitle {
            color: rgba(255,255,255,0.6);
            font-size: 14px;
            text-align: center;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            color: rgba(255,255,255,0.8);
            font-weight: 500;
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }
        .form-group .input-group {
            background: rgba(255,255,255,0.08);
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.1);
            transition: 0.3s;
            overflow: hidden;
        }
        .form-group .input-group:focus-within {
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
        }
        .form-group .input-group-text {
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.5);
            padding: 12px 15px;
        }
        .form-group .form-control {
            background: transparent;
            border: none;
            color: #fff;
            padding: 12px 15px 12px 0;
            font-size: 15px;
        }
        .form-group .form-control:focus {
            box-shadow: none;
            background: transparent;
        }
        .form-group .form-control::placeholder {
            color: rgba(255,255,255,0.3);
        }
        .btn-register {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            background: #4CAF50;
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            border: none;
            transition: 0.3s;
            cursor: pointer;
        }
        .btn-register:hover {
            background: #43a047;
            transform: scale(1.02);
            box-shadow: 0 10px 30px rgba(76, 175, 80, 0.3);
        }
        .auth-footer {
            text-align: center;
            margin-top: 20px;
            color: rgba(255,255,255,0.5);
            font-size: 14px;
        }
        .auth-footer a {
            color: #4CAF50;
            text-decoration: none;
            font-weight: 500;
        }
        .auth-footer a:hover {
            text-decoration: underline;
        }
        .alert-danger {
            background: rgba(244, 67, 54, 0.15);
            border: 1px solid rgba(244, 67, 54, 0.2);
            color: #ef9a9a;
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 14px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="card-auth">
            <div class="logo">
                <i class="bi bi-car-front-fill"></i>
            </div>
            <div class="auth-title">Qeydiyyat</div>
            <p class="auth-subtitle">Yeni hesab yarat</p>

            @if ($errors->any())
                <div class="alert-danger">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    @foreach ($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="form-group">
                    <label for="name">Ad Soyad</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-person"></i></span>
                        <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required placeholder="Ad Soyad">
                    </div>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required placeholder="your@email.com">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Şifrə</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input id="password" type="password" class="form-control" name="password" required placeholder="••••••••">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Şifrə Təkrar</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <i class="bi bi-person-plus me-2"></i> Qeydiyyat
                </button>
            </form>

            <div class="auth-footer">
                Artıq hesabın var? <a href="{{ route('login') }}">Daxil Ol</a>
            </div>
        </div>
    </div>
</body>
</html>
