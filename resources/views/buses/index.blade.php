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

<!-- Sıralama + Axtarış -->
<div class="card mb-4">
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label fw-bold">📊 Sıralama</label>
                <select class="form-select" id="sortSelect" onchange="applyFilters()">
                    <option value="id" {{ request('sort') == 'id' ? 'selected' : '' }}>ID - ə görə</option>
                    <option value="km" {{ request('sort') == 'km' ? 'selected' : '' }}>KM - ə görə</option>
                    <option value="xett_no" {{ request('sort') == 'xett_no' ? 'selected' : '' }}>Xətt № - ə görə</option>
                    <option value="dqn" {{ request('sort') == 'dqn' ? 'selected' : '' }}>DQN - ə görə</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-bold">📈 Sıra</label>
                <select class="form-select" id="orderSelect" onchange="applyFilters()">
                    <option value="asc" {{ request('order') == 'asc' ? 'selected' : '' }}>⬆ Artan (A-Z / 0-9)</option>
                    <option value="desc" {{ request('order') == 'desc' ? 'selected' : '' }}>⬇ Azalan (Z-A / 9-0)</option>
                </select>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-bold">🔍 Axtarış</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="searchInput"
                           placeholder="DQN, Xətt № və ya KM ilə axtar..."
                           oninput="applyFilters()" value="{{ request('search') }}">
                    <button class="btn btn-secondary" onclick="document.getElementById('searchInput').value=''; applyFilters();">
                        <i class="bi bi-x-circle"></i> Təmizlə
                    </button>
                </div>
                <small class="text-muted mt-2 d-block">🔍 DQN, Xətt № və ya KM ilə axtar</small>
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
    function applyFilters() {
        const sort = document.getElementById('sortSelect').value;
        const order = document.getElementById('orderSelect').value;
        const search = document.getElementById('searchInput').value;

        fetch(`{{ route('buses.search') }}?sort=${sort}&order=${order}&search=${encodeURIComponent(search)}`)
            .then(response => response.text())
            .then(html => {
                document.getElementById('searchResults').innerHTML = html;
                const count = document.querySelector('#searchResults .total-count');
                if (count) {
                    document.getElementById('totalCount').textContent = count.dataset.count;
                }
            })
            .catch(error => console.error('Xəta:', error));
    }

    // Səhifə yükləndikdə mövcud filterləri tətbiq et
    document.addEventListener('DOMContentLoaded', function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('sort')) {
            document.getElementById('sortSelect').value = urlParams.get('sort');
        }
        if (urlParams.has('order')) {
            document.getElementById('orderSelect').value = urlParams.get('order');
        }
        if (urlParams.has('search')) {
            document.getElementById('searchInput').value = urlParams.get('search');
        }
    });
</script>
@endsection
