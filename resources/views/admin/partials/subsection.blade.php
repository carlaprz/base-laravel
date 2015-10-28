@include('admin.partials.section', [
    'subsection' => true,
    'route' => 'undefined',
    'icon' => $icon,
    'name' => $name
])

<ul class="nav nav-second-level">
    @foreach ($childs as $child)
        <li>
            <a class="{{ current_route_is($child['route']) ? 'active-menu' : '' }}"
               href="{{ route($child['route']) }}">{{ $child['name'] }}</a>
        </li>
    @endforeach
</ul>
