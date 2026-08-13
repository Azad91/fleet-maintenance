@extends('layouts.app')

@section('title', 'Gündəlik KM Məlumatları')

@section('content')
<div class="container">
    <h1>📊 Gündəlik KM Məlumatları</h1>

    <div class="section-title">📋 Əsas Məlumatlar</div>

    <div class="field">
        <span class="label">ID:</span>
        <span class="value">{{ $dailyKm->id }}</span>
    </div>
    <div class="field">
        <span class="label">🚌 Avtobus:</span>
        <span class="value"><strong>{{ $dailyKm->bus->dqn ?? '-' }}</strong></span>
    </div>
    <div class="field">
        <span class="label">Xətt №:</span>
        <span class="value">{{ $dailyKm->bus->xett_no ?? '-' }}</span>
    </div>
    <div class="field">
        <span class="label">📅 Tarix:</span>
        <span class="value">{{ $dailyKm->tarix ? \Carbon\Carbon::parse($dailyKm->tarix)->format('d.m.Y') : '-' }}</span>
    </div>
    <div class="field">
        <span class="label">📊 KM (Yürüş):</span>
        <span class="value"><strong>{{ number_format($dailyKm->km, 0, ',', '.') }} km</strong></span>
    </div>

    <div class="section-title">📅 Əlavə Məlumatlar</div>
    <div class="field">
        <span class="label">Yaradılma:</span>
        <span class="value">{{ $dailyKm->created_at ? \Carbon\Carbon::parse($dailyKm->created_at)->format('d.m.Y H:i') : '-' }}</span>
    </div>
    <div class="field">
        <span class="label">Son Yenilənmə:</span>
        <span class="value">{{ $dailyKm->updated_at ? \Carbon\Carbon::parse($dailyKm->updated_at)->format('d.m.Y H:i') : '-' }}</span>
    </div>

    <br>
    <div class="d-flex gap-2">
        <a href="{{ route('daily-km.edit', $dailyKm) }}" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Redaktə Et
        </a>
        <a href="{{ route('daily-km.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Geri
        </a>
    </div>
</div>
@endsection
