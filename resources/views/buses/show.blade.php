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
        <span class="label">📊 KM (Yürüş):</span>
        <span class="value">{{ $bus->km ? number_format($bus->km, 0, ',', '.') . ' km' : '-' }}</span>
    </div>
    <div class="field">
        <span class="label">📊 Son KM (Yürüş):</span>
        <span class="value">
            @php
                $lastKm = App\Models\DailyKm::where('bus_id', $bus->id)->orderBy('tarix', 'desc')->first();
            @endphp
            {{ $lastKm ? number_format($lastKm->km, 0, ',', '.') . ' km (' . $lastKm->tarix->format('d.m.Y') . ')' : '-' }}
        </span>
    </div>
    <div class="field">
        <span class="label">Sürücü:</span>
        <span class="value">{{ $bus->surucu_adi ?? '-' }}</span>
    </div>
    <div class="field">
        <span class="label">Şikayət:</span>
        <span class="value">{{ $bus->shikayet ?? '-' }}</span>
    </div>

    <div class="section-title">🕐 Tarix və Saat</div>

    <div class="field">
        <span class="label">Bildirilme Tarix:</span>
        <span class="value">{{ $bus->bildirilme_tarix ? $bus->bildirilme_tarix->format('d.m.Y') : '-' }}</span>
    </div>
    <div class="field">
        <span class="label">Bildirilme Saat:</span>
        <span class="value">{{ $bus->bildirilme_saat ?? '-' }}</span>
    </div>
    <div class="field">
        <span class="label">İşə Başlama Tarix:</span>
        <span class="value">{{ $bus->is_baslama_tarix ? $bus->is_baslama_tarix->format('d.m.Y') : '-' }}</span>
    </div>
    <div class="field">
        <span class="label">İşə Başlama Saat:</span>
        <span class="value">{{ $bus->is_baslama_saat ?? '-' }}</span>
    </div>
    <div class="field">
        <span class="label">İşin Bitdiyi Tarix:</span>
        <span class="value">{{ $bus->is_bitme_tarix ? $bus->is_bitme_tarix->format('d.m.Y') : '-' }}</span>
    </div>
    <div class="field">
        <span class="label">İşin Bitdiyi Saat:</span>
        <span class="value">{{ $bus->is_bitme_saat ?? '-' }}</span>
    </div>

    <div class="section-title">📊 Status</div>
    <div class="field">
        <span class="label">Aktiv:</span>
        <span class="value {{ $bus->aktiv ? 'active-yes' : 'active-no' }}">
            {{ $bus->aktiv ? '✅ Aktiv' : '❌ Passiv' }}
        </span>
    </div>

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
