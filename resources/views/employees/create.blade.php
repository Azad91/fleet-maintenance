@extends('layouts.app')

@section('title', 'Yeni İşçi')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>➕ Yeni İşçi Əlavə Et</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('employees.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="ad" class="form-label fw-bold">Ad <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="ad" name="ad" required placeholder="Məs: Elşad" value="{{ old('ad') }}">
            </div>

            <div class="mb-3">
                <label for="soyad" class="form-label fw-bold">Soyad <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="soyad" name="soyad" required placeholder="Məs: Məmmədov" value="{{ old('soyad') }}">
            </div>

            <div class="mb-3">
                <label for="vezifesi" class="form-label fw-bold">Vəzifə <span class="text-danger">*</span></label>
                <select class="form-select" id="vezifesi" name="vezifesi" required>
                    <option value="">Vəzifə seçin...</option>
                    @foreach($positions as $key => $label)
                        <option value="{{ $key }}" {{ old('vezifesi') == $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="qeyd" class="form-label fw-bold">📝 Qeyd</label>
                <textarea class="form-control" id="qeyd" name="qeyd" rows="3" placeholder="Əlavə qeyd...">{{ old('qeyd') }}</textarea>
            </div>

            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="aktiv" name="aktiv" value="1" {{ old('aktiv', '1') == '1' ? 'checked' : '' }}>
                    <label class="form-check-label" for="aktiv">✅ Aktiv</label>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Yadda Saxla
                </button>
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Geri
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
