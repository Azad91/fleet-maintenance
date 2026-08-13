<div class="row g-4">
    <!-- ========== YENI ŞIKAYƏT KARTI ========== -->
    <div class="col-md-6 col-lg-4">
        <a href="{{ route('complaints.create') }}" class="text-decoration-none h-100">
            <div class="card complaint-card h-100 add-card d-flex align-items-center justify-content-center">
                <div class="text-center p-4">
                    <i class="bi bi-plus-circle-fill" style="font-size: 48px; color: #4CAF50;"></i>
                    <h5 class="mt-3 text-dark">📋 Yeni Kart</h5>
                    <p class="text-muted small mb-0">Yeni kart əlavə et</p>
                </div>
            </div>
        </a>
    </div>

    <!-- ========== ŞİKAYƏT KARTLARI ========== -->
    @forelse($complaints as $complaint)
        <div class="col-md-6 col-lg-4">
            <div class="card complaint-card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-bus-front text-primary"></i>
                        <strong>{{ $complaint->bus->dqn ?? '-' }}</strong>
                    </div>
                    <span class="badge-status {{ str_replace(' ', '-', $complaint->status) }}">
                        {{ $complaint->status }}
                    </span>
                </div>
                <div class="card-body">
                    <!-- Xətt və Yer -->
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted small">
                            <i class="bi bi-signpost"></i> Xətt: {{ $complaint->bus->xett_no ?? '-' }}
                        </span>
                        <span class="text-muted small">
                            @if($complaint->yer == 'yol')
                                <i class="bi bi-road"></i> Yol
                            @elseif($complaint->yer == 'qaraj')
                                <i class="bi bi-house"></i> Qaraj
                            @else
                                -
                            @endif
                        </span>
                    </div>

                    <!-- Şikayət -->
                    <div class="mb-2">
                        <span class="text-muted small">📝 Şikayət:</span>
                        <p class="mb-0 small">{{ Str::limit($complaint->shikayet ?? '-', 60) }}</p>
                    </div>

                    <!-- Tarix -->
                    <div class="text-muted small">
                        <i class="bi bi-calendar"></i>
                        {{ $complaint->created_at ? $complaint->created_at->format('d.m.Y H:i') : '-' }}
                    </div>
                </div>
                <div class="card-footer bg-transparent d-flex gap-1">
                    <a href="{{ route('complaints.show', $complaint) }}" class="btn btn-sm btn-primary">
                        <i class="bi bi-eye"></i> Bax
                    </a>
                    @if(Auth::user()->role == 'admin' || Auth::user()->role == 'complaint')
                        <a href="{{ route('complaints.edit', $complaint) }}" class="btn btn-sm btn-warning">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('complaints.destroy', $complaint) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Əminsən?')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <!-- ========== BOŞ VEZİYYƏT ========== -->
        <div class="col-12">
            <div class="text-center text-muted py-4">
                <i class="bi bi-clipboard" style="font-size: 40px; display: block; margin-bottom: 10px;"></i>
                @if(isset($dqn) || isset($xett_no) || isset($yer) || isset($shikayet))
                    Axtarış nəticəsində heç nə tapılmadı
                @else
                    Hələ kart yoxdur.
                    <a href="{{ route('complaints.create') }}" class="btn btn-success btn-sm mt-2">
                        <i class="bi bi-plus-lg"></i> Yenisini əlavə et!
                    </a>
                @endif
            </div>
        </div>
    @endforelse
</div>
