@extends('layouts.app')

@section('title', 'Status Məlumatları')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>📄 Status Məlumatları</h1>
        <a href="{{ route('bus-daily-statuses.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Geri
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">🚌 Avtobus</small>
                        <strong>{{ $status->bus->dqn ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">Xətt №</small>
                        <strong>{{ $status->bus->xett_no ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">📅 Tarix</small>
                        <strong>{{ $status->tarix ? \Carbon\Carbon::parse($status->tarix)->format('d.m.Y') : '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">📌 Status</small>
                        <strong>{{ $status->status }}</strong>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">📝 Qeyd</small>
                        <strong>{{ $status->qeyd ?? '-' }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
