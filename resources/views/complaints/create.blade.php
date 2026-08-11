@extends('layouts.app')

@section('title', 'Yeni Şikayət')

@section('content')
<div class="card">
    <div class="card-header">
        <h4>📋 Yeni Şikayət Əlavə Et</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('complaints.store') }}" method="POST">
            @csrf

            <!-- Avtobus seçimi -->
            <div class="mb-3">
                <label class="form-label fw-bold">🚌 Avtobus</label>
                <div class="row">
                    <div class="col-md-6">
                        <label for="xett_no" class="form-label">Xətt №</label>
                        <input type="text" class="form-control" id="xett_no" name="xett_no"
                               list="xettList" placeholder="Xətt nömrəsini yaz..."
                               oninput="getBusByXett(this.value)">
                        <datalist id="xettList">
                            @foreach($buses as $bus)
                                <option value="{{ $bus->xett_no }}">
                            @endforeach
                        </datalist>
                    </div>
                    <div class="col-md-6">
                        <label for="dqn" class="form-label">DQN</label>
                        <input type="text" class="form-control" id="dqn" name="dqn" readonly style="background:#e9ecef;">
                        <input type="hidden" name="bus_id" id="bus_id">
                    </div>
                </div>
            </div>

            <!-- Yol / Qaraj seçimi -->
            <div class="mb-3">
                <label class="form-label fw-bold">📍 Yer</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="yer" id="yer_yol" value="yol" checked onchange="toggleFields()">
                        <label class="form-check-label" for="yer_yol">🛣️ Yol</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="yer" id="yer_qaraj" value="qaraj" onchange="toggleFields()">
                        <label class="form-check-label" for="yer_qaraj">🏠 Qaraj</label>
                    </div>
                </div>
            </div>

            <!-- Sürücü adı -->
            <div class="mb-3" id="surucuField">
                <label for="surucu_adi" class="form-label fw-bold">🧑‍✈️ Sürücü Adı</label>
                <input type="text" class="form-control" id="surucu_adi" name="surucu_adi" placeholder="Məs: Elşad Məmmədov">
            </div>

            <!-- Dinamik Şikayətlər (Select ilə) -->
            <div class="mb-3">
                <label class="form-label fw-bold">📝 Şikayətlər</label>
                <div id="shikayetContainer">
                    <div class="shikayet-item mb-2">
                        <div class="input-group">
                            <span class="input-group-text" style="min-width: 40px;">1.</span>
                            <select class="form-select" name="shikayet[]" required>
                                <option value="">Şikayət seçin...</option>
                                @foreach($complaintTypes as $type)
                                    <option value="{{ $type->name }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-danger" onclick="removeShikayet(this)">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-sm mt-2" onclick="addShikayet()">
                    <i class="bi bi-plus-circle"></i> Şikayət Əlavə Et
                </button>
                <small class="text-muted d-block mt-1">Hər şikayət ayrıca seçilir.</small>
            </div>

            <!-- KM (Yürüş) -->
            <div class="mb-3">
                <label for="km" class="form-label fw-bold">📊 KM (Yürüş)</label>
                <input type="number" class="form-control" id="km" name="km"
                       placeholder="Avtobus seçildikdə avtomatik dolur..."
                       min="0" readonly style="background:#e9ecef;">
                <small class="text-muted">Avtobus seçildikdə avtomatik olaraq dolur</small>
            </div>

            <!-- Bildirilme tarix + saat -->
            <div id="bildirilmeFields">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="bildirilme_tarix" class="form-label fw-bold">📅 Bildirilme Tarix</label>
                            <input type="date" class="form-control" id="bildirilme_tarix" name="bildirilme_tarix">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="bildirilme_saat" class="form-label fw-bold">🕐 Bildirilme Saat</label>
                            <input type="time" class="form-control" id="bildirilme_saat" name="bildirilme_saat">
                        </div>
                    </div>
                </div>
            </div>

            <!-- İşə başlama -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="is_baslama_tarix" class="form-label fw-bold">📅 İşə Başlama Tarix</label>
                        <input type="date" class="form-control" id="is_baslama_tarix" name="is_baslama_tarix">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="is_baslama_saat" class="form-label fw-bold">🕐 İşə Başlama Saat</label>
                        <input type="time" class="form-control" id="is_baslama_saat" name="is_baslama_saat">
                    </div>
                </div>
            </div>

            <!-- İşin bitməsi -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="is_bitme_tarix" class="form-label fw-bold">📅 İşin Bitdiyi Tarix</label>
                        <input type="date" class="form-control" id="is_bitme_tarix" name="is_bitme_tarix">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="is_bitme_saat" class="form-label fw-bold">🕐 İşin Bitdiyi Saat</label>
                        <input type="time" class="form-control" id="is_bitme_saat" name="is_bitme_saat">
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div class="mb-3">
                <label for="status" class="form-label fw-bold">📊 Status</label>
                <select class="form-select" id="status" name="status" required>
                    <option value="gözləmədə">⏳ Gözləmədə</option>
                    <option value="işdə">🔨 İşdə</option>
                    <option value="həll olundu">✅ Həll Olundu</option>
                </select>
            </div>

            <!-- Şikayət Tipi -->
            <div class="mb-3">
                <label class="form-label fw-bold">🏷️ Şikayət Tipi</label>
                <div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sikayet_tipi" id="tip_qezali" value="qezali">
                        <label class="form-check-label" for="tip_qezali">🚗 Qəzalı</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sikayet_tipi" id="tip_nasazliq" value="nasazliq">
                        <label class="form-check-label" for="tip_nasazliq">⚠️ Nasazlıq</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sikayet_tipi" id="tip_texniki" value="texniki_xidmet">
                        <label class="form-check-label" for="tip_texniki">🔧 Texniki Xidmət</label>
                    </div>
                </div>
            </div>

            <!-- Anbar Detalları (Dinamik) -->
            <div class="card bg-light p-3 mb-3">
                <h5 class="fw-bold mb-3">🔧 İstifadə Olunan Detallar</h5>
                <div id="detallarContainer">
                    <div class="detallar-item border rounded p-3 mb-2">
                        <div class="row">
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label fw-bold">Aid Olduğu Şikayət</label>
                                    <select class="form-select" name="detallar[0][shikayet_index]">
                                        <option value="0">1. Şikayət</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label fw-bold">Detal Kodu</label>
                                    <input type="text" class="form-control" name="detallar[0][kodu]"
                                           placeholder="Məs: D-001" oninput="getDetalByKod(this, 0)">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label fw-bold">Detal Adı</label>
                                    <input type="text" class="form-control" name="detallar[0][adi]"
                                           readonly disabled style="background:#e9ecef; cursor:not-allowed;">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label fw-bold">Depo Miqdarı</label>
                                    <input type="text" class="form-control" name="detallar[0][depo_miqdari]"
                                           readonly disabled style="background:#e9ecef; cursor:not-allowed; -moz-appearance:textfield;">
                                    <style>
                                        input[name*="[depo_miqdari]"]::-webkit-outer-spin-button,
                                        input[name*="[depo_miqdari]"]::-webkit-inner-spin-button {
                                            -webkit-appearance: none;
                                            margin: 0;
                                        }
                                        input[name*="[depo_miqdari]"] {
                                            -moz-appearance: textfield;
                                        }
                                    </style>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label fw-bold">İşlənən Miqdar</label>
                                    <input type="number" class="form-control" name="detallar[0][islenen_miqdar]"
                                           placeholder="0" min="0" value="0">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="mb-2">
                                    <label class="form-label fw-bold">&nbsp;</label>
                                    <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeDetal(this)">
                                        <i class="bi bi-trash"></i> Sil
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-primary btn-sm mt-2" onclick="addDetal()">
                    <i class="bi bi-plus-circle"></i> Detal Əlavə Et
                </button>
                <small class="text-muted d-block mt-1">Hər detal hansı şikayətə aid olduğunu seçin.</small>
            </div>

            <!-- Qeyd -->
            <div class="mb-3">
                <label for="qeyd" class="form-label fw-bold">📝 Qeyd (görülən işlər)</label>
                <textarea class="form-control" id="qeyd" name="qeyd" rows="2" placeholder="Görülən işlər..."></textarea>
            </div>

            <!-- Kim iş görüb -->
            <div class="mb-3">
                <label for="kim_is_gorub" class="form-label fw-bold">👤 Kim iş görüb</label>
                <input type="text" class="form-control" id="kim_is_gorub" name="kim_is_gorub" placeholder="İşçi adı">
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Yadda Saxla
                </button>
                <a href="{{ route('complaints.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Geri
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // ==================== 1. AVTOBUS ====================
    function getBusByXett(xett_no) {
        if (!xett_no) {
            document.getElementById('dqn').value = '';
            document.getElementById('bus_id').value = '';
            document.getElementById('km').value = '';
            return;
        }

        fetch(`/get-bus-id-by-xett/${xett_no}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('dqn').value = data.dqn || '';
                document.getElementById('bus_id').value = data.bus_id || '';

                if (data.bus_id) {
                    fetch(`/get-bus-km-by-id/${data.bus_id}`)
                        .then(response => response.json())
                        .then(kmData => {
                            document.getElementById('km').value = kmData.km || '';
                        })
                        .catch(error => console.error('KM xətası:', error));
                }
            })
            .catch(error => console.error('Xəta:', error));
    }

    // ==================== 2. YOL / QARAJ ====================
    function toggleFields() {
        const yer = document.querySelector('input[name="yer"]:checked').value;
        const surucuField = document.getElementById('surucuField');
        const bildirilmeFields = document.getElementById('bildirilmeFields');

        if (yer === 'qaraj') {
            surucuField.style.display = 'none';
            bildirilmeFields.style.display = 'none';
        } else {
            surucuField.style.display = 'block';
            bildirilmeFields.style.display = 'block';
        }
    }

    // ==================== 3. DİNAMİK ŞİKAYƏTLƏR (SELECT) ====================
    function addShikayet() {
        const container = document.getElementById('shikayetContainer');
        const items = container.querySelectorAll('.shikayet-item');
        const newNumber = items.length + 1;

        const newItem = document.createElement('div');
        newItem.className = 'shikayet-item mb-2';
        newItem.innerHTML = `
            <div class="input-group">
                <span class="input-group-text" style="min-width: 40px;">${newNumber}.</span>
                <select class="form-select" name="shikayet[]" required>
                    <option value="">Şikayət seçin...</option>
                    @foreach($complaintTypes as $type)
                        <option value="{{ $type->name }}">{{ $type->name }}</option>
                    @endforeach
                </select>
                <button type="button" class="btn btn-danger" onclick="removeShikayet(this)">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(newItem);

        // Detalların seçimlərini yenilə
        updateDetalOptions();
    }

    function removeShikayet(button) {
        const item = button.closest('.shikayet-item');
        if (document.querySelectorAll('.shikayet-item').length > 1) {
            item.remove();
            updateNumbers();
            updateDetalOptions();
        } else {
            alert('Ən azı bir şikayət olmalıdır!');
        }
    }

    function updateNumbers() {
        const items = document.querySelectorAll('.shikayet-item');
        items.forEach((item, index) => {
            const numberSpan = item.querySelector('.input-group-text');
            if (numberSpan) {
                numberSpan.textContent = (index + 1) + '.';
            }
        });
    }

    // ==================== 4. DİNAMİK DETALLAR ====================
    let detalCount = 1;

    function addDetal() {
        const container = document.getElementById('detallarContainer');

        // Şikayət seçimlərini yığ
        const shikayetSelects = document.querySelectorAll('select[name="shikayet[]"]');
        let options = '';
        shikayetSelects.forEach((select, index) => {
            const selectedText = select.options[select.selectedIndex]?.text || `Şikayət ${index + 1}`;
            options += `<option value="${index}">${selectedText}</option>`;
        });

        if (!options) {
            options = `<option value="0">Şikayət 1</option>`;
        }

        const newItem = document.createElement('div');
        newItem.className = 'detallar-item border rounded p-3 mb-2';
        newItem.innerHTML = `
            <div class="row">
                <div class="col-md-2">
                    <div class="mb-2">
                        <label class="form-label fw-bold">Aid Olduğu Şikayət</label>
                        <select class="form-select" name="detallar[${detalCount}][shikayet_index]">
                            ${options}
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-2">
                        <label class="form-label fw-bold">Detal Kodu</label>
                        <input type="text" class="form-control" name="detallar[${detalCount}][kodu]"
                               placeholder="Məs: D-001" oninput="getDetalByKod(this, ${detalCount})">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-2">
                        <label class="form-label fw-bold">Detal Adı</label>
                        <input type="text" class="form-control" name="detallar[${detalCount}][adi]"
                               readonly disabled style="background:#e9ecef; cursor:not-allowed;">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-2">
                        <label class="form-label fw-bold">Depo Miqdarı</label>
                        <input type="text" class="form-control" name="detallar[${detalCount}][depo_miqdari]"
                               readonly disabled style="background:#e9ecef; cursor:not-allowed; -moz-appearance:textfield;">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-2">
                        <label class="form-label fw-bold">İşlənən Miqdar</label>
                        <input type="number" class="form-control" name="detallar[${detalCount}][islenen_miqdar]"
                               placeholder="0" min="0" value="0">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-2">
                        <label class="form-label fw-bold">&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeDetal(this)">
                            <i class="bi bi-trash"></i> Sil
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.appendChild(newItem);
        detalCount++;
    }

    function removeDetal(button) {
        const item = button.closest('.detallar-item');
        if (document.querySelectorAll('.detallar-item').length > 1) {
            item.remove();
        } else {
            alert('Ən azı bir detal olmalıdır!');
        }
    }

    // ==================== 5. DETALLARIN SEÇİMLƏRİNİ YENİLƏ ====================
    function updateDetalOptions() {
        const shikayetSelects = document.querySelectorAll('select[name="shikayet[]"]');
        const detalSelects = document.querySelectorAll('select[name*="[shikayet_index]"]');

        detalSelects.forEach(select => {
            const currentValue = parseInt(select.value) || 0;
            select.innerHTML = '';

            shikayetSelects.forEach((shikayetSelect, index) => {
                const text = shikayetSelect.options[shikayetSelect.selectedIndex]?.text || `Şikayət ${index + 1}`;
                const option = document.createElement('option');
                option.value = index;
                option.textContent = text;
                if (index === currentValue) {
                    option.selected = true;
                }
                select.appendChild(option);
            });

            if (select.options.length === 0) {
                const option = document.createElement('option');
                option.value = 0;
                option.textContent = 'Şikayət 1';
                select.appendChild(option);
            }
        });
    }

    // Şikayət select - i dəyişəndə detalları yenilə
    document.addEventListener('change', function(e) {
        if (e.target && e.target.name === 'shikayet[]') {
            updateDetalOptions();
        }
    });

    // ==================== 6. DETAL KODUNA GÖRƏ ANBAR - DAN MƏLUMAT ÇƏK ====================
    function getDetalByKod(input, index) {
        const kod = input.value;
        const item = input.closest('.detallar-item');
        const adiInput = item.querySelector('input[name*="[adi]"]');
        const depoInput = item.querySelector('input[name*="[depo_miqdari]"]');

        if (!kod) {
            adiInput.value = '';
            depoInput.value = '';
            return;
        }

        fetch(`/get-detal-by-kod/${kod}`)
            .then(response => response.json())
            .then(data => {
                adiInput.value = data.detal_adi || '';
                depoInput.value = data.depo_miqdari || '';
            })
            .catch(error => console.error('Xəta:', error));
    }

    // ==================== 7. SƏHİFƏ YÜKLƏNDİKDƏ ====================
    document.addEventListener('DOMContentLoaded', function() {
        toggleFields();
    });
</script>
@endsection
