@extends('layouts.app')

@section('title', 'Şikayət Növü Redaktə Et')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>✏️ Şikayət Növü Redaktə Et</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('complaint-types.update', $type) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label fw-bold">Ad <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" required value="{{ old('name', $type->name) }}">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Yenilə
                </button>
                <a href="{{ route('complaint-types.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Geri
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
