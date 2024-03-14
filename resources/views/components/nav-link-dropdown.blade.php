<li class="nav-item @if (in_array(Request::url(), $route)) menu-is-opening menu-open @endif">
    <a href="#" class="nav-link">
        <i class="nav-icon {{ $icon }}" style="color: {{ $color }}"></i>
        <p>
            {{ $title }}
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview" style="display: @if (in_array(Request::url(), $route)) block @else none @endif;">
        {{ $slot }}
    </ul>
</li>
