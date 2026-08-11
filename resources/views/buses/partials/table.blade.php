<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Xətt №</th>
                        <th>DQN</th>
                        <th>KM (Yürüş)</th>
                        <th>Status</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($buses as $bus)
                    <tr>
                        <td>{{ $bus->id }}</td>
                        <td>{{ $bus->xett_no ?? '-' }}</td>
                        <td><strong>{{ $bus->dqn }}</strong></td>
                        <td>{{ $bus->km ? number_format($bus->km, 0, ',', '.') . ' km' : '-' }}</td>
                        <td>
                            <span class="badge-status {{ $bus->aktiv ? 'aktiv' : 'passiv' }}">
                                {{ $bus->aktiv ? '✅ Aktiv' : '❌ Passiv' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('buses.show', $bus) }}" class="btn btn-sm btn-primary">👁️ Bax</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted py-4">
                            <i class="bi bi-bus-front" style="font-size: 40px; display: block; margin-bottom: 10px;"></i>
                            @if(isset($search) && $search)
                                "<strong>{{ $search }}</strong>" üzrə heç nə tapılmadı
                            @else
                                Hələ avtobus yoxdur. <a href="{{ route('buses.import') }}">Excel - dən yüklə!</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <span class="total-count d-none" data-count="{{ $buses->count() }}"></span>
        </div>
    </div>
</div>
