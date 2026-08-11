@extends('layouts.app')

@section('title', 'Excel - dən Gündəlik KM Yüklə')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>📂 Excel - dən Gündəlik KM Yüklə</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('daily-km.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <strong>Excel Formatı:</strong>
                <ul class="mt-2 mb-0">
                    <li><strong>dqn</strong> - Avtobusun DQN - i <span class="text-danger">*</span></li>
                    <li><strong>tarix</strong> - Tarix (Y-m-d) <span class="text-danger">*</span></li>
                    <li><strong>km</strong> - Yürüş (km) <span class="text-danger">*</span></li>
                </ul>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label fw-bold">Excel Faylı Seçin (.xlsx, .xls, .csv)</label>
                <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls,.csv" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-upload"></i> Yüklə
                </button>
                <a href="{{ route('daily-km.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Geri
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
