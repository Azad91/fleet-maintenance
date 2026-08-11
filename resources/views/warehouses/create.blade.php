@extends('layouts.app')

@section('title', 'Yeni Anbar Məhsulu')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>📦 Yeni Anbar Məhsulu Əlavə Et</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('warehouses.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="kod" class="form-label fw-bold">Kod <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="kod" name="kod" required placeholder="Məs: D-001">
            </div>

            <div class="mb-3">
                <label for="ad" class="form-label fw-bold">Ad <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ad" name="ad" required placeholder="Məs: Filtr">
            </div>

            <div class="mb-3">
                <label for="miqdar" class="form-label fw-bold">Depo Miqdarı (Anbarda olan qalıq)</label>
                <input type="number" class="form-control" id="miqdar" name="miqdar" min="0" value="0" placeholder="0">
            </div>

            <div class="mb-3">
                <label for="olcu_vahidi" class="form-label fw-bold">Ölçü Vahidi</label>
                <select class="form-select" id="olcu_vahidi" name="olcu_vahidi">
                    <option value="">Seç...</option>
                    <option value="ədəd">Ədəd</option>
                    <option value="litr">Litr</option>
                    <option value="metr">Metr</option>
                    <option value="kq">Kiloqram</option>
                    <option value="q">Qram</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="qiymet" class="form-label fw-bold">Vahid Qiyməti (AZN)</label>
                <input type="number" class="form-control" id="qiymet" name="qiymet" step="0.01" min="0" placeholder="1 ədəd/litr/metr üçün qiymət">
                <small class="text-muted">1 ədəd, 1 litr və ya 1 metr üçün qiymət</small>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Yadda Saxla
                </button>
                <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Geri
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
