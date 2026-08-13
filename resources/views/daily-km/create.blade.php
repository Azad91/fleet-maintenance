@extends('layouts.app')

@section('title', 'Yeni KM Əlavə Et')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>📊 Yeni KM Əlavə Et</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('daily-km.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="bus_id" class="form-label fw-bold">🚌 Avtobus <span class="text-danger">*</span></label>
                <select class="form-select" id="bus_id" name="bus_id" required>
                    <option value="">Avtobus seçin...</option>
                    @foreach($buses as $bus)
                        <option value="{{ $bus->id }}" {{ request('bus_id') == $bus->id ? 'selected' : '' }}>
                            {{ $bus->dqn }} - Xətt: {{ $bus->xett_no ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tarix" class="form-label fw-bold">📅 Tarix <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="tarix" name="tarix" required value="{{ old('tarix', date('Y-m-d')) }}">
            </div>

            <div class="mb-3">
                <label for="km" class="form-label fw-bold">📊 KM (Yürüş) <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="km" name="km" required placeholder="Məs: 36000" min="0" value="{{ old('km') }}">
                <small class="text-muted">Avtobusun həmin günə olan yürüşü</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Yadda Saxla
                </button>
                <a href="{{ route('daily-km.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Geri
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
