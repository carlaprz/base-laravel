<div class="wrapper">
    <input type="hidden" name="_token" id="csrf-token-favorites" value="{{ Session::token() }}" />

    @include('front.complements.header.elements')

    <nav id="navigation">
        @include('front.complements.header.navigation')
    </nav>

    @if(!empty($categoriesNav) && !Request::is('friperie-potoroze/*'))
        @include('front.complements.header.secondNavigation',['categoriesNav', $categoriesNav])
        <div class="line"></div>
    @endif

</div>
