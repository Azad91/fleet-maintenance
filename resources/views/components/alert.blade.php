@if($message)
    <div class="alert alert-{{ $type }} alert-dismissible fade show" role="alert">
        <i class="bi bi-{{ $type == 'success' ? 'check-circle-fill' : ($type == 'danger' ? 'exclamation-triangle-fill' : 'info-circle-fill') }} me-2"></i>
        {{ $message }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
