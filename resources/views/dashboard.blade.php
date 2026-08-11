@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row">
    <div class="col-12">
        <h1 class="mb-4">🚀 Dashboard</h1>
    </div>
</div>

<!-- Stat Cards -->
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card stat-card bg-primary-gradient">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="count">{{ $totalBuses ?? 0 }}</div>
                    <div class="label">🚌 Avtobuslar</div>
                </div>
                <div class="icon"><i class="bi bi-bus-front"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-warning-gradient">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="count">{{ $totalComplaints ?? 0 }}</div>
                    <div class="label">📋 Şikayətlər</div>
                </div>
                <div class="icon"><i class="bi bi-clipboard"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-success-gradient">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="count">{{ $totalWarehouses ?? 0 }}</div>
                    <div class="label">📦 Anbar Məhsulları</div>
                </div>
                <div class="icon"><i class="bi bi-box-seam"></i></div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-info-gradient">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="count">{{ $lowStockItems->count() ?? 0 }}</div>
                    <div class="label">⚠️ Tükənən Məhsullar</div>
                </div>
                <div class="icon"><i class="bi bi-exclamation-triangle"></i></div>
            </div>
        </div>
    </div>
</div>

<!-- Son Avtobuslar -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">🚌 Son Avtobuslar</h5>
        <a href="{{ route('buses.index') }}" class="btn btn-sm btn-primary">Hamısına Bax</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Xətt №</th>
                        <th>DQN</th>
                        <th>Sürücü</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBuses ?? [] as $bus)
                    <tr>
                        <td>{{ $bus->id }}</td>
                        <td>{{ $bus->xett_no ?? '-' }}</td>
                        <td><strong>{{ $bus->dqn }}</strong></td>
                        <td>{{ $bus->surucu_adi ?? '-' }}</td>
                        <td>
                            <span class="badge-status {{ $bus->aktiv ? 'aktiv' : 'passiv' }}">
                                {{ $bus->aktiv ? '✅ Aktiv' : '❌ Passiv' }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Hələ avtobus yoxdur</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Son Şikayətlər + Tükənən Məhsullar -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">📋 Son Şikayətlər</h5>
                <a href="{{ route('complaints.index') }}" class="btn btn-sm btn-primary">Hamısına Bax</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Avtobus</th>
                                <th>Şikayət</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentComplaints ?? [] as $complaint)
                            <tr>
                                <td><strong>{{ $complaint->bus->dqn ?? '-' }}</strong></td>
                                <td>{{ Str::limit($complaint->shikayet ?? '-', 20) }}</td>
                                <td>
                                    <span class="badge-status {{ str_replace(' ', '-', $complaint->status) }}">
                                        {{ $complaint->status }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">Hələ şikayət yoxdur</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">⚠️ Tükənən Məhsullar</h5>
                <a href="{{ route('warehouses.index') }}" class="btn btn-sm btn-primary">Hamısına Bax</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Kod</th>
                                <th>Ad</th>
                                <th>Miqdar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($lowStockItems ?? [] as $item)
                            <tr>
                                <td><strong>{{ $item->kod }}</strong></td>
                                <td>{{ $item->ad }}</td>
                                <td>
                                    <span class="text-danger">{{ $item->miqdar }}</span>
                                    <small class="text-muted">(min: {{ $item->minimum_miqdar }})</small>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">✅ Bütün məhsullar kifayət qədərdir</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
