@extends('layouts.app')

@section('title', 'Yeni Şikayət Növü')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>➕ Yeni Şikayət Növü Əlavə Et</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('complaint-types.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Ad <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" required placeholder="Məs: Mühərrik səsi">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Yadda Saxla
                </button>
                <a href="{{ route('complaint-types.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Geri
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
