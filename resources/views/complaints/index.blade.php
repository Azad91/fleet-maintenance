@extends('layouts.app')

@section('title', 'Kartlar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>📋 Kartlar</h1>
    <div>
        <a href="{{ route('complaint-types.index') }}" class="btn btn-info" target="_blank">
            <i class="bi bi-tags"></i> Şikayət Başlıqları
        </a>
        <a href="{{ route('complaints.create') }}" class="btn btn-success">
            <i class="bi bi-plus-lg"></i> Yeni Kart
        </a>
    </div>
</div>

<!-- Axtarış Formu -->
<form id="searchForm" class="mb-4">
    <div class="card">
        <div class="card-body">
            <div class="row g-2">
                <div class="col">
                    <input type="text" class="form-control form-control-sm" name="dqn" placeholder="🔍 DQN..." value="{{ request('dqn') }}">
                </div>
                <div class="col">
                    <input type="text" class="form-control form-control-sm" name="xett_no" placeholder="🔍 Xətt №..." value="{{ request('xett_no') }}">
                </div>
                <div class="col">
                    <select class="form-select form-control-sm" name="yer">
                        <option value="">📍 Yer</option>
                        <option value="yol" {{ request('yer') == 'yol' ? 'selected' : '' }}>🛣️ Yol</option>
                        <option value="qaraj" {{ request('yer') == 'qaraj' ? 'selected' : '' }}>🏠 Qaraj</option>
                    </select>
                </div>
                <div class="col">
                    <input type="text" class="form-control form-control-sm" name="shikayet" placeholder="🔍 Şikayət..." value="{{ request('shikayet') }}">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bi bi-search"></i> Axtar
                    </button>
                </div>
                <div class="col-auto">
                    <a href="{{ route('complaints.index') }}" class="btn btn-secondary btn-sm w-100">
                        <i class="bi bi-arrow-counterclockwise"></i> Sıfırla
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>

<!-- Nəticələr -->
<div id="searchResults">
    @include('complaints.partials.cards', ['complaints' => $complaints])
</div>
@endsection

@section('scripts')
<script>
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        const params = new URLSearchParams();

        for (let [key, value] of formData.entries()) {
            if (value) {
                params.append(key, value);
            }
        }

        fetch(`{{ route('complaints.search') }}?${params.toString()}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('searchResults').innerHTML = html;
            })
            .catch(error => console.error('Xəta:', error));
    });
</script>
@endsection
