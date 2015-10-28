<div class="wrapper">
    <input type="hidden" name="_token" id="csrf-token-favorites" value="{{ Session::token() }}" />

    @include('front.complements.headerMobile.elements')

    <nav id="navigation">
        @include('front.complements.headerMobile.navigation')
    </nav>

    @if(!empty($categoriesNav))
        @include('front.complements.headerMobile.secondNavigation',['categoriesNav', $categoriesNav])
        <div class="line"></div>
    @endif

</div>
