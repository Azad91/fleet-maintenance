@extends('layouts.app')

@section('title', 'Excel - dən Şikayət Yüklə')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>📂 Excel - dən Şikayət Yüklə</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('complaints.import.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <strong>Excel Formatı:</strong>
                <ul class="mt-2 mb-0">
                    <li><strong>bus_dqn</strong> - Avtobusun DQN - i <span class="text-danger">*</span> (məcburi)</li>
                    <li><strong>yer</strong> - Yer (yol / qaraj)</li>
                    <li><strong>surucu_adi</strong> - Sürücü adı</li>
                    <li><strong>shikayet</strong> - Şikayət mətni</li>
                    <li><strong>sikayet_tipi</strong> - Şikayət tipi (qezali / texniki_xidmet / nasazliq)</li>
                    <li><strong>bildirilme_tarix</strong> - Bildirilme tarix (Y-m-d)</li>
                    <li><strong>bildirilme_saat</strong> - Bildirilme saat (H:i)</li>
                    <li><strong>is_baslama_tarix</strong> - İş başlama tarix (Y-m-d)</li>
                    <li><strong>is_baslama_saat</strong> - İş başlama saat (H:i)</li>
                    <li><strong>is_bitme_tarix</strong> - İş bitmə tarix (Y-m-d)</li>
                    <li><strong>is_bitme_saat</strong> - İş bitmə saat (H:i)</li>
                    <li><strong>status</strong> - Status (gözləmədə / işdə / həll olundu)</li>
                    <li><strong>detal_kodu</strong> - Detal kodu (anbarla əlaqə)</li>
                    <li><strong>detal_adi</strong> - Detal adı</li>
                    <li><strong>islenen_miqdar</strong> - İşlənən miqdar (anbardan çıxar)</li>
                    <li><strong>km</strong> - Yürüş (kilometr)</li>
                    <li><strong>qeyd</strong> - Qeyd</li>
                    <li><strong>kim_is_gorub</strong> - Kim iş görüb</li>
                </ul>
                <p class="mt-2 mb-0 text-danger">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>depo_miqdari</strong> - avtomatik olaraq anbardan götürülür, Excel - də yazmağa ehtiyac yoxdur.
                </p>
            </div>

            <div class="mb-3">
                <label for="file" class="form-label fw-bold">Excel Faylı Seçin (.xlsx, .xls, .csv)</label>
                <input type="file" class="form-control" id="file" name="file" accept=".xlsx,.xls,.csv" required>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-upload"></i> Yüklə
                </button>
                <a href="{{ route('complaints.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Geri
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
