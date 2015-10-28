<div class="wrapper">
    <a class="logo-min" href="{{ route('home') }}">
        <img src="{{ asset('front/images/logo-min.png') }}" alt="Logo"/>
        <h2 class="slogan">@lang('msg.slogan_footer')</h2>
    </a>
    <div class="claim">
        @if($texto != '')
            {{ $texto }}
        @else
            {!! nl2br(trans('msg.footer_claim')) !!}
        @endif

    </div>
    <div class="claim">
        <div class="col" id="colsFot">
            <ul>
                <li class="title" data-toggle-mobile>
                    POTOROZE.COM
                    <img src="{{ asset('front/images/suma.png') }}"/>
                </li>
                <li><a rel="nofollow" href="{{ route('about-us') }}">@lang('msg.about')</a></li>
                <li><a rel="nofollow" href="{{ route('colab') }}"> @lang('msg.collaboration') </a></li>
                <li><a rel="nofollow" href="{{ route('terms') }}"> @lang('msg.conditions') </a></li>
                <li><a rel="nofollow" href="{{ route('protecction') }}"> @lang('msg.protection') </a></li>
                <li><a rel="nofollow" href="{{ route('contact') }}"> @lang('msg.contact') </a></li>
            </ul>
        </div>
        <div class="col">
            <ul>
                <li class="title" data-toggle-mobile>
                    <a rel="nofollow" href="{{route('faqs')}}"> @lang('msg.faq')</a>
                    <img src="{{ asset('front/images/suma.png') }}"/>
                </li>
                @foreach($faqsCategories as $faqCategory)
                    <li><a rel="nofollow" href="{{route('faqs')}}#category-{{$faqCategory->id}}">{{$faqCategory->name}}</a></li>
                @endforeach
            </ul>
        </div>

        @foreach ($parentCategories as $category )
        <div class="col">
            <ul>
                <li class="title" data-toggle-mobile>
                    <a href="{{route('category',['slug'=>$category->slug])}}"> {{$category->name}} </a><img src="{{ asset('front/images/suma.png') }}"/>
                </li>
                @foreach ($category->childs() as $subCategory )
                    <li><a href="{{route('category.subcategory',['slug' => $subCategory->slug,'slugParent' => $category->slug])}}">{{$subCategory->name}}</a></li>
                @endforeach
            </ul>
        </div>
        @endforeach

        <div class="col">
            <ul>
                <li class="title" data-toggle-mobile> @lang('msg.top_marks') <img src="{{ asset('front/images/suma.png') }}"/> </li>
                @foreach ($topMarks as $mark )
                    <li><a href="{{route('mark.details',$mark->slug)}}">{{$mark->name}}</a></li>
                @endforeach
                <li><a href="{{ route('marks') }}"> > {{$cantMarks}} @lang('msg.marks_footer')</a></li>
            </ul>
        </div>

        <ul id="footer_legals">
            <li><a rel="nofollow" href="{{ route('about-us') }}"> @lang('msg.about') </a></li>
            <li><a rel="nofollow" href="{{ route('contact') }}"> @lang('msg.contact') </a></li>
            <li><a rel="nofollow" href="{{ route('marks') }}"> @lang('msg.marks_footer') </a></li>
            <li><a rel="nofollow" href="{{ route('protecction') }}"> @lang('msg.legal') </a></li>
            <li><a rel="nofollow" href="{{ route('faqs') }}"> @lang('msg.faq') </a></li>
            <li><a href="/sitemaps/index.xml">@lang('msg.web_map')</a></li>
        </ul>
    </div>
    <div class="claim">
        <ul id="search-bar">
            <li>
                <form class="search_footer" method="get" id="form_search" action="">
                    <label for="search">
                        <input name="_token" id="csrf-token-search" value="{{ Session::token() }}" type="hidden">
                        <input type="text" name="search" placeholder="Potoroze.com" id="search"/>
                        <button type="button"><i class="fa fa-play"></i></button>
                    </label>
                </form>
            </li>
        </ul>
        <ul id="social-bar">
            <li><a href="https://www.facebook.com/Potoroze" target="_blank"><i class="fa fa-facebook"></i></a></li>
            <li><a href="https://twitter.com/potoroze" target="_blank"><i class="fa fa-twitter"></i></a></li>
            <li><a href="https://plus.google.com/118437914122102458032/about" target="_blank"><i class="fa fa-google-plus"></i></a></li>
            <li><a href="https://www.pinterest.com/potoroze/" target="_blank"><i class="fa fa-pinterest-p"></i></a></li>
            <li><a href="https://instagram.com/potoroze" target="_blank"><i class="fa fa-instagram"></i></a></li>
        </ul>

        <script type="application/ld+json">
            {
            "@context" : "http://schema.org",
            "@type" : "Organization",
            "name" : "Potoroze",
            "url" : "http://www.Potoroze.com",
            "sameAs" : [
            "https://www.facebook.com/Potoroze",
            "https://twitter.com/potoroze",
            "https://plus.google.com/118437914122102458032/about",
            "https://www.pinterest.com/potoroze/",
            "https://instagram.com/potoroze"
            ]
            }
        </script>
    </div>
</div>

