<nav class="navbar-default navbar-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav" id="main-menu">
             @foreach (config('menu') as $section)
                  @if (array_key_exists('dropdown', $section))
                      <li class="{{ subsection_is_active($section['childs']) ? 'active' : '' }}">
                          @include('admin.partials.subsection', $section)
                      </li>
                  @else
                      <li>
                          @include('admin.partials.section', $section)
                      </li>
                  @endif
             @endforeach

        </ul>
    </div>
</nav>
