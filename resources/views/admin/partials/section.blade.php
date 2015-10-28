<a class="{{ current_route_is($route) ? 'active-menu' : '' }}"
   href="{{ isset($subsection) ? '#' : route($route) }}">
    <i class="fa fa-{{ $icon }}"></i>
    {{ $name }}
    @if (isset($subsection))
        <span class="fa arrow"></span>
    @endif
</a>
