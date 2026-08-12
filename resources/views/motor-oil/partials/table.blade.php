@if(isset($search) && $search && $grouped->count() == 0)
    <div class="alert alert-warning">
        <i class="bi bi-exclamation-triangle"></i>
        "<strong>{{ $search }}</strong>" KM - ə uyğun heç nə tapılmadı.
    </div>
@endif

@forelse($grouped as $km => $items)
    @php
        $items = $items->sortBy('detal_adi');
    @endphp
    <div class="card mb-4">
        <div class="card-body">
            <h4 class="fw-bold text-primary">
                📍 {{ number_format($km, 0, ',', '.') }} KM
                <span class="badge bg-secondary">{{ $items->count() }} detal</span>
            </h4>
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th style="width: 60px; text-align: center;">#</th>
                            <th style="width: 150px;">Detal Kodu</th>
                            <th>Detal Adı</th>
                            <th style="width: 100px; text-align: center;">Vahid</th>
                            <th style="width: 100px; text-align: center;">Miqdar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $index => $item)
                        <tr>
                            <td style="text-align: center;">{{ $index + 1 }}</td>
                            <td><strong>{{ $item->detal_kodu }}</strong></td>
                            <td>{{ $item->detal_adi }}</td>
                            <td style="text-align: center;">{{ $item->olcu_vahidi ?? '-' }}</td>
                            <td style="text-align: center;">{{ number_format($item->miqdar, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@empty
    <div class="text-center text-muted py-4">
        <i class="bi bi-inbox" style="font-size: 40px; display: block; margin-bottom: 10px;"></i>
        Hələ motor yağ detalları əlavə edilməyib.
    </div>
@endforelse

<!-- Total count - u gizli saxlamaq üçün -->
<span class="total-count d-none" data-count="{{ $grouped->sum(function($items) { return $items->count(); }) }}"></span>
