@extends('layouts.app')

@section('title', 'Excel - dən Anbar Yüklə')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>📂 Excel - dən Anbar Yüklə</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('warehouses.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <strong>Excel Formatı:</strong>
                <ul class="mt-2 mb-0">
                    <li><strong>kod</strong> - Məhsul kodu <span class="text-danger">*</span> (məcburi, unikal)</li>
                    <li><strong>ad</strong> - Məhsul adı <span class="text-danger">*</span></li>
                    <li><strong>miqdar</strong> - Depo miqdarı</li>
                    <li><strong>olcu_vahidi</strong> - Ölçü vahidi (ədəd, litr, metr, kq, q)</li>
                    <li><strong>qiymet</strong> - Qiymət (AZN)</li>
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
                <a href="{{ route('warehouses.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Geri
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
