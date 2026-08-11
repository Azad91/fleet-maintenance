@extends('layouts.app')

@section('title', 'Gündəlik KM')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>📊 Gündəlik KM</h1>
    <div>
        <a href="{{ route('daily-km.import') }}" class="btn btn-success">
            <i class="bi bi-upload"></i> Excel - dən Yüklə
        </a>
        <a href="{{ route('daily-km.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Yeni KM
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Avtobus (DQN)</th>
                        <th>Tarix</th>
                        <th>KM</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($dailyKms as $item)
                    <tr>
                        <td>{{ $item->id }}</td>
                        <td><strong>{{ $item->bus->dqn ?? '-' }}</strong></td>
                        <td>{{ $item->tarix ? $item->tarix->format('d.m.Y') : '-' }}</td>
                        <td>{{ number_format($item->km, 0, ',', '.') }} km</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('daily-km.show', $item) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('daily-km.edit', $item) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('daily-km.destroy', $item) }}" method="POST" style="display:inline">
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
                        <td colspan="5" class="text-center text-muted">Hələ gündəlik KM məlumatı yoxdur</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
