@extends('layouts.app')

@section('title', 'Motor Yağ Detalları - Excel Yüklə')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>📂 Motor Yağ Detalları - Excel Yüklə</h4>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form action="{{ route('motor-oil.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <strong>Excel Formatı:</strong>
                <ul class="mt-2 mb-0">
                    <li><strong>adi</strong> - Detal adı</li>
                    <li><strong>olcu_vahidi</strong> - Ölçü vahidi (litr, ədəd, kq)</li>
                    <li><strong>miqdar</strong> - Bir dəfəlik miqdar</li>
                    <li><strong>kod</strong> - Detal kodu</li>
                    <li><strong>36000, 72000, ...</strong> - Km sütunları (neçə dəfə dəyişilir)</li>
                </ul>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label fw-bold">Excel Faylı Seçin (.xlsx, .xls, .csv)</label>
                <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls,.csv" required>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="bi bi-upload"></i> Yüklə
            </button>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Geri
            </a>
        </form>
    </div>
</div>
@endsection
