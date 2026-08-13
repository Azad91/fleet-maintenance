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
<div class="card mb-4">
    <div class="card-body">
        <form id="searchForm" class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-bold">DQN</label>
                <input type="text" class="form-control" id="dqn" name="dqn" placeholder="DQN ilə axtar..." value="{{ request('dqn') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Xətt №</label>
                <input type="text" class="form-control" id="xett_no" name="xett_no" placeholder="Xətt № ilə axtar..." value="{{ request('xett_no') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Yer</label>
                <select class="form-select" id="yer" name="yer">
                    <option value="">Hamısı</option>
                    <option value="yol" {{ request('yer') == 'yol' ? 'selected' : '' }}>🛣️ Yol</option>
                    <option value="qaraj" {{ request('yer') == 'qaraj' ? 'selected' : '' }}>🏠 Qaraj</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">Şikayət</label>
                <input type="text" class="form-control" id="shikayet" name="shikayet" placeholder="Şikayət mətni..." value="{{ request('shikayet') }}">
            </div>
            <div class="col-12 text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-search"></i> Axtar
                </button>
                <a href="{{ route('complaints.create') }}" class="btn btn-info">
                    <i class="bi bi-plus-lg"></i> Yeni Kart
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Nəticələr -->
<div id="searchResults">
    @include('complaints.partials.cards', ['complaints' => $complaints])
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputs = document.querySelectorAll('#searchForm input, #searchForm select');
        const form = document.getElementById('searchForm');

        inputs.forEach(input => {
            input.addEventListener('input', function() {
                submitSearch();
            });
            input.addEventListener('change', function() {
                submitSearch();
            });
        });

        function submitSearch() {
            const formData = new FormData(form);
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
        }
    });
</script>
@endsection
