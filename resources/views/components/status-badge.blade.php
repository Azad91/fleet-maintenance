@php
    $class = match($status) {
        'gözləmədə' => 'gözləmədə',
        'işdə' => 'işdə',
        'həll olundu' => 'həll-olundu',
        'aktiv' => 'aktiv',
        'passiv' => 'passiv',
        'temir' => 'temir',
        default => '',
    };
@endphp

<span class="badge-status {{ $class }}">
    {{ $status }}
</span>
