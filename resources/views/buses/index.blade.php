@extends('layouts.app')

@section('title', 'Avtobuslar')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>🚌 Avtobuslar</h1>
    <div>
        <a href="{{ route('buses.import') }}" class="btn btn-success">
            <i class="bi bi-upload"></i> Excel - dən Yüklə
        </a>
    </div>
</div>

<!-- AXTARIŞ + SIRALAMA -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold">🔍 Axtarış</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="searchInput"
                           placeholder="DQN və ya Xətt № ilə axtar..."
                           value="{{ request('search') }}"
                           oninput="liveSearch()">
                    <button class="btn btn-secondary" onclick="document.getElementById('searchInput').value=''; liveSearch();">
                        <i class="bi bi-x-circle"></i>
                    </button>
                </div>
            </div>

            <div class="col-md-3">
                <label class="form-label fw-bold">📊 Sıralama</label>
                <select class="form-select" id="sortSelect" onchange="liveSearch()">
                    <option value="id" {{ request('sort') == 'id' ? 'selected' : '' }}>ID - ə görə</option>
                    <option value="dqn" {{ request('sort') == 'dqn' ? 'selected' : '' }}>DQN - ə görə</option>
                    <option value="xett_no" {{ request('sort') == 'xett_no' ? 'selected' : '' }}>Xətt № - ə görə</option>
                    <option value="km" {{ request('sort') == 'km' ? 'selected' : '' }}>KM - ə görə</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="form-label fw-bold">📈 Sıra</label>
                <select class="form-select" id="orderSelect" onchange="liveSearch()">
                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>⬆ Artan</option>
                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>⬇ Azalan</option>
                </select>
            </div>

            <div class="col-md-3">
                <a href="{{ route('buses.index') }}" class="btn btn-secondary w-100">
                    <i class="bi bi-arrow-counterclockwise"></i> Sıfırla
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Nəticələr -->
<div id="searchResults">
    @include('buses.partials.table', ['buses' => $buses])
</div>
@endsection

@section('scripts')
<script>
    let searchTimeout;

    function liveSearch() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(function() {
            const search = document.getElementById('searchInput').value;
            const sort = document.getElementById('sortSelect').value;
            const order = document.getElementById('orderSelect').value;

            const params = new URLSearchParams();
            if (search) params.append('search', search);
            if (sort) params.append('sort', sort);
            if (order) params.append('order', order);

            fetch(`{{ route('buses.search') }}?${params.toString()}`)
                .then(response => response.text())
                .then(html => {
                    document.getElementById('searchResults').innerHTML = html;
                })
                .catch(error => console.error('Xəta:', error));
        }, 300); // 300ms gözlə
    }

    // Səhifə yükləndikdə əgər search varsa, avtomatik axtar
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchInput');
        if (searchInput.value) {
            liveSearch();
        }
    });
</script>
@endsection
