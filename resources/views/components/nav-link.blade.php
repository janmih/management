{{-- @props(['active'])

@php
    $classes = $active ?? false ? 'nav-link active' : 'nav-link';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    <p>
        {{ $slot }}
    </p>
</a> --}}
<li class="nav-item">
    <a href="{{ $route }}" class="nav-link @if (Request::url() == $route) active @endif">
        <i class="nav-icon {{ $icon }}" style="color: {{ $color }}"></i>
        <p>
            {{ $slot }}
        </p>
    </a>
</li>
