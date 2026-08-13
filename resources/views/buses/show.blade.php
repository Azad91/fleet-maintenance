@extends('layouts.app')

@section('title', 'Avtobus Məlumatları')

@section('content')
<div class="container">
    <h1>🚌 Avtobus Məlumatları</h1>

    <div class="section-title">📋 Əsas Məlumatlar</div>

    <div class="field">
        <span class="label">ID:</span>
        <span class="value">{{ $bus->id }}</span>
    </div>
    <div class="field">
        <span class="label">Xətt №:</span>
        <span class="value">{{ $bus->xett_no ?? '-' }}</span>
    </div>
    <div class="field">
        <span class="label">DQN:</span>
        <span class="value"><strong>{{ $bus->dqn }}</strong></span>
    </div>
    <div class="field">
        <span class="label">📊 Cari KM (Yürüş):</span>
        <span class="value">{{ $bus->km ? number_format($bus->km, 0, ',', '.') . ' km' : '-' }}</span>
    </div>
    <div class="field">
        <span class="label">📅 Son Yenilənmə:</span>
        <span class="value">{{ $bus->tarix ? \Carbon\Carbon::parse($bus->tarix)->format('d.m.Y') : '-' }}</span>
    </div>

    <div class="section-title">📊 Status</div>
    <div class="field">
        <span class="label">Aktiv:</span>
        <span class="value {{ $bus->aktiv ? 'active-yes' : 'active-no' }}">
            {{ $bus->aktiv ? '✅ Aktiv' : '❌ Passiv' }}
        </span>
    </div>

    <!-- ========================================== -->
    <!-- 📊 KM TARİXÇƏSİ -->
    <!-- ========================================== -->
    <div class="section-title mt-4">
        📊 KM Tarixçəsi
        <a href="{{ route('daily-km.create') }}?bus_id={{ $bus->id }}" class="btn btn-sm btn-success ms-2">
            <i class="bi bi-plus-lg"></i> KM Əlavə Et
        </a>
        <a href="{{ route('daily-km.import') }}" class="btn btn-sm btn-info ms-1">
            <i class="bi bi-upload"></i> Excel - dən Yüklə
        </a>
    </div>

    @php
        $dailyKms = $bus->dailyKms()->orderBy('tarix', 'desc')->paginate(15);
    @endphp

    @if($dailyKms->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>📅 Tarix</th>
                                <th>📊 KM</th>
                                <th>Əməliyyatlar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dailyKms as $index => $item)
                            <tr>
                                <td>{{ $dailyKms->firstItem() + $index }}</td>
                                <td>{{ $item->tarix ? $item->tarix->format('d.m.Y') : '-' }}</td>
                                <td><strong>{{ number_format($item->km, 0, ',', '.') }} km</strong></td>
                                <td>
                                    <a href="{{ route('daily-km.edit', $item) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('daily-km.destroy', $item) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Əminsən?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($dailyKms->hasPages())
                    <div class="pagination-wrapper">
                        {{ $dailyKms->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center text-muted py-4">
                <i class="bi bi-graph-up" style="font-size: 40px; display: block; margin-bottom: 10px;"></i>
                Hələ bu avtobus üçün KM məlumatı yoxdur.
                <br>
                <a href="{{ route('daily-km.create', ['bus_id' => $bus->id]) }}" class="btn btn-success btn-sm mt-2">
                    <i class="bi bi-plus-lg"></i> İlk KM - nı əlavə et
                </a>
                <a href="{{ route('daily-km.import') }}" class="btn btn-info btn-sm mt-2">
                    <i class="bi bi-upload"></i> Excel - dən yüklə
                </a>
            </div>
        </div>
    @endif

    @if($bus->detallar && is_array($bus->detallar) && count($bus->detallar) > 0)
    <div class="section-title">🔧 Detallar</div>
    @foreach($bus->detallar as $index => $detail)
    <div class="detail-card">
        <h4 style="margin-top:0;">Detal #{{ $index + 1 }}</h4>
        <div class="detail-row">
            <div class="detail-item">
                <strong>Kod:</strong> {{ $detail['kodu'] ?? '-' }}
            </div>
            <div class="detail-item">
                <strong>Adı:</strong> {{ $detail['adi'] ?? '-' }}
            </div>
        </div>
        <div class="detail-row">
            <div class="detail-item">
                <strong>Anbar Miqdarı:</strong> {{ $detail['anbar_miqdari'] ?? 0 }}
            </div>
            <div class="detail-item">
                <strong>Detalın Sayı:</strong> {{ $detail['sayi'] ?? 0 }}
            </div>
        </div>
        <div class="detail-row">
            <div class="detail-item">
                <strong>İşlənib:</strong>
                @if(isset($detail['islenib']) && $detail['islenib'] == 1)
                    <span class="badge badge-islenib">✅ Bəli</span>
                @else
                    <span class="badge badge-islenmeyib">❌ Xeyr</span>
                @endif
            </div>
            <div class="detail-item">
                <strong>Şikayət Tipi:</strong>
                @if(isset($detail['sikayet_tipi']))
                    @switch($detail['sikayet_tipi'])
                        @case('qezali')
                            <span class="badge badge-qezali">🚗 Qəzalı</span>
                            @break
                        @case('texniki_xidmet')
                            <span class="badge badge-texniki">🔧 Texniki Xidmət</span>
                            @break
                        @case('nasazliq')
                            <span class="badge badge-nasazliq">⚠️ Nasazlıq</span>
                            @break
                        @default
                            <span>-</span>
                    @endswitch
                @else
                    -
                @endif
            </div>
        </div>
        <div class="detail-row">
            <div class="detail-item" style="flex: 2;">
                <strong>Qeyd:</strong> {{ $detail['qeyd'] ?? '-' }}
            </div>
        </div>
        <div class="detail-row">
            <div class="detail-item">
                <strong>Kim iş görüb:</strong> {{ $detail['kim_is_gorub'] ?? '-' }}
            </div>
        </div>
    </div>
    @endforeach
    @endif

    <br>
    <a href="{{ route('buses.index') }}" class="btn btn-secondary">⬅ Geri</a>
</div>
@endsection
