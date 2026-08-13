@extends('layouts.app')

@section('title', 'Excel - dən İşçi Yüklə')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>📂 Excel - dən İşçi Yüklə</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('employees.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <strong>Excel Formatı:</strong>
                <ul class="mt-2 mb-0">
                    <li><strong>ad</strong> - İşçinin adı <span class="text-danger">*</span></li>
                    <li><strong>soyad</strong> - İşçinin soyadı <span class="text-danger">*</span></li>
                    <li><strong>vezifesi</strong> - Vəzifəsi (usta, mexanik, surucu, elektrik, qaynaqci, boyakar, digər)</li>
                    <li><strong>aktiv</strong> - Aktiv (true / false, 1 / 0)</li>
                    <li><strong>qeyd</strong> - Əlavə qeyd</li>
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
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Geri
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
