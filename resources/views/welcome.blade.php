<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fleet Maintenance</title>
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
        .welcome-container {
            max-width: 900px;
            width: 100%;
            padding: 20px;
        }
        .card-welcome {
            background: rgba(255,255,255,0.05);
            backdrop-filter: blur(20px);
            border-radius: 30px;
            padding: 50px;
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 25px 50px rgba(0,0,0,0.5);
            text-align: center;
        }
        .logo {
            font-size: 60px;
            color: #4CAF50;
            margin-bottom: 15px;
        }
        h1 {
            color: #fff;
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 10px;
            letter-spacing: 1px;
        }
        h1 span {
            color: #4CAF50;
        }
        .subtitle {
            color: rgba(255,255,255,0.7);
            font-size: 18px;
            margin-bottom: 30px;
        }
        .features {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }
        .feature-item {
            background: rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 20px;
            border: 1px solid rgba(255,255,255,0.06);
            transition: 0.3s;
        }
        .feature-item:hover {
            background: rgba(255,255,255,0.15);
            transform: translateY(-3px);
        }
        .feature-item i {
            font-size: 30px;
            color: #4CAF50;
            margin-bottom: 8px;
            display: block;
        }
        .feature-item h6 {
            color: #fff;
            font-weight: 600;
            margin-bottom: 4px;
        }
        .feature-item p {
            color: rgba(255,255,255,0.6);
            font-size: 13px;
            margin: 0;
        }
        .btn-group-custom {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn-custom {
            padding: 12px 40px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            text-decoration: none;
            transition: 0.3s;
            border: none;
        }
        .btn-login {
            background: #4CAF50;
            color: #fff;
        }
        .btn-login:hover {
            background: #43a047;
            color: #fff;
            transform: scale(1.05);
            box-shadow: 0 10px 30px rgba(76, 175, 80, 0.3);
        }
        .btn-register {
            background: rgba(255,255,255,0.15);
            color: #fff;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .btn-register:hover {
            background: rgba(255,255,255,0.25);
            color: #fff;
            transform: scale(1.05);
        }
        .footer-text {
            color: rgba(255,255,255,0.3);
            font-size: 13px;
            margin-top: 25px;
            border-top: 1px solid rgba(255,255,255,0.06);
            padding-top: 20px;
        }
        .footer-text a {
            color: rgba(255,255,255,0.5);
            text-decoration: none;
        }
        .footer-text a:hover {
            color: #4CAF50;
        }

        @media (max-width: 768px) {
            .card-welcome { padding: 30px 20px; }
            h1 { font-size: 28px; }
            .features { grid-template-columns: 1fr; }
            .btn-custom { padding: 10px 25px; font-size: 14px; }
        }
    </style>
</head>
<body>
    <div class="welcome-container">
        <div class="card-welcome">
            <div class="logo">
                <i class="bi bi-car-front-fill"></i>
            </div>
            <h1>Fleet <span>Maintenance</span></h1>
            <p class="subtitle">
                Avtobus parkınızın idarə edilməsi üçün tam həll
            </p>

            <div class="features">
                <div class="feature-item">
                    <i class="bi bi-bus-front"></i>
                    <h6>Avtobuslar</h6>
                    <p>Bütün avtobus məlumatları</p>
                </div>
                <div class="feature-item">
                    <i class="bi bi-clipboard"></i>
                    <h6>Şikayətlər</h6>
                    <p>Problem və nasazlıqlar</p>
                </div>
                <div class="feature-item">
                    <i class="bi bi-box-seam"></i>
                    <h6>Anbar</h6>
                    <p>Ehtiyat hissələri</p>
                </div>
            </div>

            <div class="btn-group-custom">
                <a href="{{ route('login') }}" class="btn-custom btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Daxil Ol
                </a>
                <a href="{{ route('register') }}" class="btn-custom btn-register">
                    <i class="bi bi-person-plus"></i> Qeydiyyat
                </a>
            </div>

            <div class="footer-text">
                &copy; {{ date('Y') }} Fleet Maintenance. Bütün hüquqlar qorunur.
            </div>
        </div>
    </div>
</body>
</html>
