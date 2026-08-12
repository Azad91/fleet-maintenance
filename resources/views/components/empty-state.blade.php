<div class="text-center text-muted py-4">
    <i class="bi bi-{{ $icon }}" style="font-size: 40px; display: block; margin-bottom: 10px;"></i>
    <p>{{ $message }}</p>
    @if($link)
        <a href="{{ $link }}" class="btn btn-sm btn-primary">{{ $linkText }}</a>
    @endif
</div>
