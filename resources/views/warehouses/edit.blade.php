@extends('layouts.app')

@section('title', 'Anbar Məhsulu - Redaktə Et')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>✏️ Anbar Məhsulu - Redaktə Et</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('warehouses.update', $warehouse->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="kod" class="form-label fw-bold">Kod <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="kod" name="kod" required value="{{ old('kod', $warehouse->kod) }}">
            </div>

            <div class="mb-3">
                <label for="ad" class="form-label fw-bold">Ad <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ad" name="ad" required value="{{ old('ad', $warehouse->ad) }}">
            </div>

            <div class="mb-3">
                <label for="miqdar" class="form-label fw-bold">Depo Miqdarı</label>
                <input type="number" class="form-control" id="miqdar" name="miqdar" min="0" value="{{ old('miqdar', $warehouse->miqdar) }}">
            </div>

            <div class="mb-3">
                <label for="olcu_vahidi" class="form-label fw-bold">Ölçü Vahidi</label>
                <select class="form-select" id="olcu_vahidi" name="olcu_vahidi">
                    <option value="">Seç...</option>
                    <option value="ədəd" {{ $warehouse->olcu_vahidi == 'ədəd' ? 'selected' : '' }}>Ədəd</option>
                    <option value="litr" {{ $warehouse->olcu_vahidi == 'litr' ? 'selected' : '' }}>Litr</option>
                    <option value="metr" {{ $warehouse->olcu_vahidi == 'metr' ? 'selected' : '' }}>Metr</option>
                    <option value="kq" {{ $warehouse->olcu_vahidi == 'kq' ? 'selected' : '' }}>Kiloqram</option>
                    <option value="q" {{ $warehouse->olcu_vahidi == 'q' ? 'selected' : '' }}>Qram</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="qiymet" class="form-label fw-bold">Qiymət (AZN)</label>
                <input type="number" class="form-control" id="qiymet" name="qiymet" step="0.01" min="0" value="{{ old('qiymet', $warehouse->qiymet) }}">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Yenilə
                </button>
                <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Geri
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
