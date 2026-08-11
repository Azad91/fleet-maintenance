<!DOCTYPE html>
<html lang="az">
<head>
    <meta charset="UTF-8">
    <title>Anbar Məhsulu - Məlumatlar</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .field { margin: 12px 0; padding: 8px; border-bottom: 1px solid #eee; }
        .label { font-weight: bold; color: #555; min-width: 150px; display: inline-block; }
        .value { color: #333; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block; }
        .btn-warning { background: #ff9800; color: white; }
        .btn-secondary { background: #666; color: white; }
        h1 { color: #333; }
        .section-title { background: #4CAF50; color: white; padding: 10px; border-radius: 4px; margin-top: 20px; }
        .status-good { color: #4CAF50; font-weight: bold; }
        .status-low { color: #ff9800; font-weight: bold; }
        .status-empty { color: #f44336; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📦 Anbar Məhsulu - Məlumatlar</h1>

        <div class="section-title">📋 Əsas Məlumatlar</div>
        <div class="field">
            <span class="label">ID:</span>
            <span class="value">{{ $warehouse->id }}</span>
        </div>
        <div class="field">
            <span class="label">Kod:</span>
            <span class="value"><strong>{{ $warehouse->kod }}</strong></span>
        </div>
        <div class="field">
            <span class="label">Ad:</span>
            <span class="value">{{ $warehouse->ad }}</span>
        </div>
        <div class="field">
            <span class="label">Kateqoriya:</span>
            <span class="value">{{ $warehouse->kateqoriya ?? '-' }}</span>
        </div>
        <div class="field">
            <span class="label">Ölçü Vahidi:</span>
            <span class="value">{{ $warehouse->olcu_vahidi ?? '-' }}</span>
        </div>

        <div class="section-title">📊 Stok Məlumatları</div>
        <div class="field">
            <span class="label">Miqdar:</span>
            <span class="value">
                <strong>{{ $warehouse->miqdar }}</strong>
                @if($warehouse->miqdar <= 0)
                    <span class="status-empty">🔴 Bitib</span>
                @elseif($warehouse->miqdar <= $warehouse->minimum_miqdar)
                    <span class="status-low">🟡 Tükənir</span>
                @else
                    <span class="status-good">🟢 Normal</span>
                @endif
            </span>
        </div>
        <div class="field">
            <span class="label">Minimum Miqdar:</span>
            <span class="value">{{ $warehouse->minimum_miqdar }}</span>
        </div>
        <div class="field">
            <span class="label">Vahid Qiyməti:</span>
            <span class="value">{{ $warehouse->qiymet ? number_format($warehouse->qiymet, 2) . ' ₼' : '-' }}</span>
        </div>
        <div class="field">
            <span class="label">Cəmi Qiymət:</span>
            <span class="value">
                <strong>{{ $warehouse->qiymet ? number_format($warehouse->miqdar * $warehouse->qiymet, 2) . ' ₼' : '-' }}</strong>
            </span>
        </div>

        <div class="section-title">🏢 Tədarükçü</div>
        <div class="field">
            <span class="label">Tədarükçü:</span>
            <span class="value">{{ $warehouse->tedarikci ?? '-' }}</span>
        </div>

        <div class="section-title">📝 Qeyd</div>
        <div class="field">
            <span class="label">Qeyd:</span>
            <span class="value">{{ $warehouse->qeyd ?? '-' }}</span>
        </div>

        <div class="field">
            <span class="label">Yaradılma:</span>
            <span class="value">{{ $warehouse->created_at }}</span>
        </div>
        <div class="field">
            <span class="label">Yenilənmə:</span>
            <span class="value">{{ $warehouse->updated_at }}</span>
        </div>

        <br>
        <a href="{{ route('warehouses.edit', $warehouse) }}" class="btn btn-warning">✏️ Redaktə Et</a>
        <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">⬅ Geri</a>
    </div>
</body>
</html>
