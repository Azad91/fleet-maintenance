@extends('layouts.app')

@section('title', 'Sürücü Məlumatları')

@section('content')
<div class="container">
    <h1>🧑‍✈️ Sürücü Məlumatları</h1>

    <div class="card">
        <div class="card-body">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">Kod</small>
                        <strong>{{ $driver->kodu }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">Ad</small>
                        <strong>{{ $driver->ad }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">Soyad</small>
                        <strong>{{ $driver->soyad ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">Telefon</small>
                        <strong>{{ $driver->telefon ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">Vəzifəsi</small>
                        <strong>{{ $driver->vezifesi ?? '-' }}</strong>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">Status</small>
                        <strong>
                            <span class="badge-status {{ $driver->aktiv ? 'aktiv' : 'passiv' }}">
                                {{ $driver->aktiv ? '✅ Aktiv' : '❌ Passiv' }}
                            </span>
                        </strong>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3 bg-light rounded">
                        <small class="text-muted d-block">📝 Qeyd</small>
                        <strong>{{ $driver->qeyd ?? '-' }}</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <br>
    <a href="{{ route('drivers.index') }}" class="btn btn-secondary">⬅ Geri</a>
    <a href="{{ route('drivers.edit', $driver) }}" class="btn btn-warning">✏️ Redaktə Et</a>
</div>
@endsection