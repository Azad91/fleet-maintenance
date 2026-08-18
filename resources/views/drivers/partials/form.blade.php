<div class="mb-3">
    <label for="kodu" class="form-label fw-bold">Kod <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="kodu" name="kodu" required
           value="{{ old('kodu', $driver->kodu ?? '') }}" placeholder="Məs: D-001">
</div>

<div class="mb-3">
    <label for="ad" class="form-label fw-bold">Ad <span class="text-danger">*</span></label>
    <input type="text" class="form-control" id="ad" name="ad" required
           value="{{ old('ad', $driver->ad ?? '') }}" placeholder="Məs: Elşad">
</div>

<div class="mb-3">
    <label for="soyad" class="form-label fw-bold">Soyad</label>
    <input type="text" class="form-control" id="soyad" name="soyad"
           value="{{ old('soyad', $driver->soyad ?? '') }}" placeholder="Məs: Məmmədov">
</div>

<div class="mb-3">
    <label for="telefon" class="form-label fw-bold">Telefon</label>
    <input type="text" class="form-control" id="telefon" name="telefon"
           value="{{ old('telefon', $driver->telefon ?? '') }}" placeholder="Məs: +994 50 123 45 67">
</div>

<div class="mb-3">
    <label for="vezifesi" class="form-label fw-bold">Vəzifəsi</label>
    <input type="text" class="form-control" id="vezifesi" name="vezifesi"
           value="{{ old('vezifesi', $driver->vezifesi ?? '') }}" placeholder="Məs: Əsas Sürücü">
</div>

<div class="mb-3">
    <label class="form-label fw-bold">Status</label>
    <div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="aktiv" id="aktiv_yes" value="1"
                   {{ old('aktiv', $driver->aktiv ?? true) == '1' ? 'checked' : '' }}>
            <label class="form-check-label" for="aktiv_yes">✅ Aktiv</label>
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="aktiv" id="aktiv_no" value="0"
                   {{ old('aktiv', $driver->aktiv ?? true) == '0' ? 'checked' : '' }}>
            <label class="form-check-label" for="aktiv_no">❌ Passiv</label>
        </div>
    </div>
</div>

<div class="mb-3">
    <label for="qeyd" class="form-label fw-bold">📝 Qeyd</label>
    <textarea class="form-control" id="qeyd" name="qeyd" rows="3">{{ old('qeyd', $driver->qeyd ?? '') }}</textarea>
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-success">
        <i class="bi bi-save"></i> Yadda Saxla
    </button>
    <a href="{{ route('drivers.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Geri
    </a>
</div>