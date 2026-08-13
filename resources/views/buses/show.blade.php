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
        <span class="badge bg-primary ms-2">{{ $bus->dailyKms()->count() }} qeyd</span>
        <div class="float-end">
            <a href="{{ route('daily-km.create') }}?bus_id={{ $bus->id }}" class="btn btn-sm btn-success ms-2">
                <i class="bi bi-plus-lg"></i> KM Əlavə Et
            </a>
            <a href="{{ route('daily-km.import') }}" class="btn btn-sm btn-info ms-1">
                <i class="bi bi-upload"></i> Excel - dən Yüklə
            </a>
        </div>
    </div>

    <!-- Tarixə görə AXTARIŞ -->
    <div class="card mb-3">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-4">
                    <label class="form-label fw-bold">📅 Tarix</label>
                    <input type="date" class="form-control" id="tarixFilter" onchange="filterKm()">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-bold">📊 KM Aralığı</label>
                    <div class="d-flex gap-2">
                        <input type="number" class="form-control" id="kmMin" placeholder="Min KM" oninput="filterKm()">
                        <span class="align-self-center">-</span>
                        <input type="number" class="form-control" id="kmMax" placeholder="Max KM" oninput="filterKm()">
                    </div>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-secondary w-100" onclick="resetFilters()">
                        <i class="bi bi-arrow-counterclockwise"></i> Sıfırla
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Nəticələr -->
    @php
        $dailyKms = $bus->dailyKms()->orderBy('tarix', 'desc')->get();
    @endphp

    @if($dailyKms->count() > 0)
        <div class="card">
            <div class="card-body">
                <div class="table-responsive" style="max-height: 500px; overflow-y: auto;">
                    <table class="table table-hover table-striped" id="kmTable">
                        <thead class="sticky-top bg-white">
                            <tr>
                                <th>#</th>
                                <th>📅 Tarix</th>
                                <th>📊 KM</th>
                                <th>Əməliyyatlar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($dailyKms as $index => $item)
                            <tr class="km-row" data-tarix="{{ $item->tarix ? $item->tarix->format('Y-m-d') : '' }}" data-km="{{ $item->km ?? 0 }}">
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->tarix ? $item->tarix->format('d.m.Y') : '-' }}</td>
                                <td><strong>{{ $item->km ? number_format($item->km, 0, ',', '.') . ' km' : '-' }}</strong></td>
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
                <div class="mt-2 text-muted">
                    <small>Cəmi: <strong>{{ $dailyKms->count() }}</strong> qeyd</small>
                </div>
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-body text-center text-muted py-4">
                <i class="bi bi-graph-up" style="font-size: 40px; display: block; margin-bottom: 10px;"></i>
                Hələ bu avtobus üçün KM məlumatı yoxdur.
                <br>
                <a href="{{ route('daily-km.create') }}?bus_id={{ $bus->id }}" class="btn btn-success btn-sm mt-2">
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

@section('scripts')
<script>
    function filterKm() {
        const tarix = document.getElementById('tarixFilter').value;
        const kmMin = document.getElementById('kmMin').value;
        const kmMax = document.getElementById('kmMax').value;

        const rows = document.querySelectorAll('.km-row');

        rows.forEach(row => {
            const rowTarix = row.dataset.tarix;
            const rowKm = parseInt(row.dataset.km);

            let show = true;

            if (tarix && rowTarix !== tarix) {
                show = false;
            }
            if (kmMin && rowKm < parseInt(kmMin)) {
                show = false;
            }
            if (kmMax && rowKm > parseInt(kmMax)) {
                show = false;
            }

            row.style.display = show ? '' : 'none';
        });
    }

    function resetFilters() {
        document.getElementById('tarixFilter').value = '';
        document.getElementById('kmMin').value = '';
        document.getElementById('kmMax').value = '';
        filterKm();
    }
</script>
@endsection
