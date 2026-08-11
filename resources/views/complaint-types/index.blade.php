@extends('layouts.app')

@section('title', 'Şikayət Növləri')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>📋 Şikayət Növləri</h1>
    <div>
        <a href="{{ route('complaint-types.import') }}" class="btn btn-success">
            <i class="bi bi-upload"></i> Excel - dən Yüklə
        </a>
        <a href="{{ route('complaint-types.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Yeni Şikayət Növü
        </a>
        <a href="{{ route('complaints.create') }}" class="btn btn-info">
            <i class="bi bi-plus-lg"></i> Yeni Şikayət
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
                        <th>Ad</th>
                        <th>Əməliyyatlar</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($types as $type)
                    <tr>
                        <td>{{ $type->id }}</td>
                        <td><strong>{{ $type->name }}</strong></td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('complaint-types.edit', $type) }}" class="btn btn-sm btn-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('complaint-types.destroy', $type) }}" method="POST" style="display:inline">
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
                        <td colspan="3" class="text-center text-muted">Hələ şikayət növü yoxdur</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
