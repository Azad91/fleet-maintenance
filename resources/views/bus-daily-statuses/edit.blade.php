@extends('layouts.app')

@section('title', 'Status Redaktə Et')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>✏️ Status Redaktə Et</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('bus-daily-statuses.update', $status) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="bus_id" class="form-label fw-bold">🚌 Avtobus <span class="text-danger">*</span></label>
                <select class="form-select" id="bus_id" name="bus_id" required>
                    <option value="">Avtobus seçin...</option>
                    @foreach($buses as $bus)
                        <option value="{{ $bus->id }}" {{ $status->bus_id == $bus->id ? 'selected' : '' }}>
                            {{ $bus->dqn }} - Xətt: {{ $bus->xett_no ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="tarix" class="form-label fw-bold">📅 Tarix <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="tarix" name="tarix" required value="{{ \Carbon\Carbon::parse($status->tarix)->format('Y-m-d') }}">
            </div>

            <div class="mb-3">
                <label for="status" class="form-label fw-bold">📌 Status <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="status" name="status" required value="{{ $status->status }}">
            </div>

            <div class="mb-3">
                <label for="qeyd" class="form-label fw-bold">📝 Qeyd</label>
                <textarea class="form-control" id="qeyd" name="qeyd" rows="3">{{ $status->qeyd }}</textarea>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Yenilə
                </button>
                <a href="{{ route('bus-daily-statuses.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Geri
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
