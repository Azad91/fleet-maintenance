<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kod</th>
                        <th>Ad</th>
                        <th>Miqdar</th>
                        <th>Ölçü Vahidi</th>
                        <th>Vahid Qiyməti</th>
                        <th>Cəmi Qiymət</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($warehouses as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td><strong>{{ $item->kod }}</strong></td>
                        <td>{{ $item->ad }}</td>
                        <td>
                            {{ $item->miqdar }}
                            @if($item->miqdar <= 0)
                                <span class="text-danger">⚠️</span>
                            @elseif($item->miqdar <= 5)
                                <span class="text-warning">⚠️</span>
                            @endif
                        </td>
                        <td>{{ $item->olcu_vahidi ?? '-' }}</td>
                        <td>{{ $item->qiymet ? number_format($item->qiymet, 2) . ' ₼' : '-' }}</td>
                        <td>
                            @if($item->qiymet)
                                <strong>{{ number_format($item->miqdar * $item->qiymet, 2) }} ₼</strong>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('warehouses.show', $item) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('warehouses.edit', $item) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('warehouses.destroy', $item) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Əminsən?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="bi bi-box-seam" style="font-size: 40px; display: block; margin-bottom: 10px;"></i>
                            @if(isset($search) && $search)
                                "<strong>{{ $search }}</strong>" üzrə heç nə tapılmadı
                            @else
                                Hələ anbarda məhsul yoxdur
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <span class="total-count d-none" data-count="{{ $warehouses->count() }}"></span>
        </div>
    </div>
</div>
