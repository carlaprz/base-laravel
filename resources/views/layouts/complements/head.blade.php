@if( Request::is("search/*") || Request::is("moncompte") || Request::is("my-account/*") || Request::is("myAccount/*") || Request::is("creer-un-look") )

<title>{{ $title or 'Potoroze' }}</title>
<meta name="robots" content="noindex">

@elseif(Request::is("/") || Request::is("home"))

<title>Vetement fashion - Guide shopping | Potoroze </title>
<meta name="description" content="Potoroze ,  votre guide shopping en mode femme, homme, enfant et beauté . Achetez neuf ou d'occasion sur Potoroze.">

@elseif(Request::is("creer-un-look"))

<title>créer une tenue fashion | Potoroze</title>
<meta name="description" content="Composez, photographiez et partagez vos meilleurs looks créés avec vos tenues préférées.">

@elseif(Request::is("looks"))

<title>idées tenues fashion | Potoroze</title>
<meta name="description" content="Découvrez les looks des it-girls et bloggeuses fashion et cool . Inspirez-vous et créez vos propres looks avec vos tenues préférées !">

@elseif(Request::is("look/*") && !empty($look))

<title>idées look fashion {{$look->name}} | Potoroze</title>
<meta name="description" content="Découvrez {{$look->user_name}}, son look, ses tenues street style. Inspirez-vous et venez rejoindre la communauté Potoroze.">

<meta property="og:title" content="idées look fashion {{$look->name}} | Potoroze">
<meta property="og:type" content="look">
<meta property="og:site_name" content="{{ $title or 'Potoroze' }}">
<meta property="og:description" content="Découvrez {{$look->user_name}}, son look, ses tenues street style. Inspirez-vous et venez rejoindre la communauté Potoroze.">
<?php $images = $look->images_front;
      $image = (!empty($images[1]))?asset($images[1]["imagePath"]):""; ?>
<meta property="og:image" content="{{$image}}">
<meta property="og:url" content="{{ Request::url()}}">

@elseif(Request::is("bonsplans"))

<title>code reduc , code promotionnel | Potoroze </title>
<meta name="description" content="Économisez sur vos marques préférées avec les codes promos gratuits en exclusivités sur Potoroze . Trouvez votre code reduc avant d’acheter !">

@if(isset($bonsplans) && !empty($bonsplans->currentPage()))
    @if($bonsplans->currentPage() != 1)
        <link rel="prev" href="{{ $bonsplans->url($bonsplans->currentPage()-1) }}" />
    @endif

    @if($bonsplans->currentPage() != $bonsplans->lastPage())
        <link rel="next" href="{{ $bonsplans->url($bonsplans->currentPage()+1) }}" />
    @endif
@endif

@elseif(Request::is("p/*") && !empty($product))

<title>{{$product->name}} {{$product->subsubcategory_name}} | {{ $title or 'Potoroze' }}</title>
<meta name="description" content="Découvrez sur Potoroze les {{$product->name}} pour {{$product->subsubcategory_name}} Une sélection mode pour un look parfait à tout moment de la journée.">
<meta property="og:title" content="{{$product->name}}">
<meta property="og:type" content="product">
<meta property="og:site_name" content="{{ $title or 'Potoroze' }}">
<meta property="og:description" content="{{$product->description}}">
<meta property="og:image" content="{{$product->image}}">
<meta property="og:url" content="{{ Request::url()}}">

@elseif(Request::is("friperie-potoroze"))

<title>friperie en ligne, vetement vintage | Potoroze</title>
<meta name="description" content="Achetez et vendez dans notre friperie en ligne Potoroze des articles vintage de qualité pour femme, homme et enfant. Toute la mode d'occasion à petit prix.">

@elseif(Request::is("friperie-potoroze/d/*") && !empty($ad))

<title>{{$ad->title}} {{$ad->subsubcategory_name}} | {{ $title or 'Potoroze' }}</title>
<meta name="description" content="Sur Frip'Potoroze vous trouverez les dernières tendances {{$ad->title}}  vintage pour {{$ad->grand_parent_category_name}}.">

<meta property="og:title" content="{{$ad->title}}">
<meta property="og:type" content="product">
<meta property="og:site_name" content="{{ $title or 'Potoroze' }}">
<meta property="og:description" content="{{$ad->description}}">
<meta property="og:url" content="{{ Request::url()}}">

@elseif(Request::is("friperie-potoroze/*"))

 @if(isset($subcategory) && !empty($subcategory) )
 
    @if(isset($subsubcategory) && !empty($subsubcategory) )
        <title> {{$subsubcategory->name}} {{$subcategory->name}} {{$category->name}}  occasion| Potoroze </title>
        <meta name="description" content="Sur Frip'Potoroze vous trouverez toutes les tendances {{$subsubcategory->name}} d'occasion du moment. Créez un style unique avec des articles vintage.">
    @else
        <title> {{$subcategory->name}} {{$category->name}} occasion | Potoroze </title>
        <meta name="description" content="{{$subcategory->name}}  vintage pour {{$category->name}} sur Frip'Potoroze. Styles et looks pas chers pour les amoureux de la mode.">

    @endif
 @else
    @if(isset($category)  && !empty($category))
        <title> friperie en ligne {{$category->name}} occasion | Potoroze </title>
        <meta name="description" content="Toute la mode vintage pour {{$category->name}} pas cher. Achetez des marques d'occasion sur Frip'Potoroze, les dernières tendances sans vous ruiner.">
    @else
        <title>friperie en ligne, vetement vintage | Potoroze</title>
        <meta name="description" content="Achetez et vendez dans notre friperie en ligne Potoroze des articles vintage de qualité pour femme, homme et enfant. Toute la mode d'occasion à petit prix.">
    @endif
 @endif  
 


@if(isset($items) && !empty($items->currentPage()))
    @if($items->currentPage() != 1)
        <link rel="prev" href="{{ $items->url($items->currentPage()-1) }}" />
    @endif

    @if($items->currentPage() != $items->lastPage())
        <link rel="next" href="{{ $items->url($items->currentPage()+1) }}" />
    @endif
@endif

@elseif(Request::is("marques"))

<title>vetement de marque pas cher | Potoroze</title>
<meta name="description" content="Potoroze vous propose une sélection des meilleures marques du secteur de la mode et de la beauté.">


@elseif(Request::is("marques/*") && !empty($mark))


@if(isset($category))
 @if(isset($subcategory))
    @if(isset($subsubcategory))
        <title> {{$subsubcategory->name}} {{$mark->name}} {{$subcategory->name}} {{$category->name}} pas cher | Potoroze </title>
    @else
        <title> {{$subcategory->name}} {{$mark->name}} {{$category->name}} pas cher | Potoroze </title>
    @endif
 @else
    <title> {{$mark->name}} {{$category->name}} pas cher | Potoroze </title>
 @endif  
 
@else
    <title> vetement de marque {{$mark->name}} | Potoroze </title>
@endif

<meta name="description" content="Découvrez la marque {{$mark->name}} sur Potoroze votre guide shopping de mode tendance . Vous ne pourrez pas y résister !">
@if(isset($products) && !empty($products->currentPage()))
    @if($products->currentPage() != 1)
        <link rel="prev" href="{{ $products->url($products->currentPage()-1) }}" />
    @endif

    @if($products->currentPage() != $products->lastPage())
        <link rel="next" href="{{ $products->url($products->currentPage()+1) }}" />
    @endif
@endif

@elseif(isset($subsubcategory) && !empty($subsubcategory) && !empty($subsubcategory->meta_title))

<title>{{$subsubcategory->meta_title}}</title>
<meta name="description" content="{{$subsubcategory->meta_description}}">

<meta property="og:title" content="{{$subsubcategory->meta_title}}">
<meta property="og:type" content="category">
<meta property="og:site_name" content="{{ $title or 'Potoroze' }}">
<meta property="og:description" content="{{$subsubcategory->meta_description}}">
<meta property="og:url" content="{{ Request::url()}}">

@if(isset($products) && !empty($products->currentPage()))
    @if($products->currentPage() != 1)
        <link rel="prev" href="{{ $products->url($products->currentPage()-1) }}" />
    @endif

    @if($products->currentPage() != $products->lastPage())
        <link rel="next" href="{{ $products->url($products->currentPage()+1) }}" />
    @endif
@endif

@elseif(isset($subcategory) && !empty($subcategory) && !empty($subcategory->meta_title))

<title>{{$subcategory->meta_title}}</title>
<meta name="description" content="{{$subcategory->meta_description}}">

<meta property="og:title" content="{{$subcategory->meta_title}}">
<meta property="og:type" content="category">
<meta property="og:site_name" content="{{ $title or 'Potoroze' }}">
<meta property="og:description" content="{{$subcategory->meta_description}}">
<meta property="og:url" content="{{ Request::url()}}">

@if(isset($products) && !empty($products->currentPage()))
    @if($products->currentPage() != 1)
        <link rel="prev" href="{{ $products->url($products->currentPage()-1) }}" />
    @endif

    @if($products->currentPage() != $products->lastPage())
        <link rel="next" href="{{ $products->url($products->currentPage()+1) }}" />
    @endif
@endif

@elseif(isset($category) && !empty($category))

<title>{{$category->meta_title}}</title>
<meta name="description" content="{{$category->meta_description}}">

<meta property="og:title" content="{{$category->meta_title}}">
<meta property="og:type" content="category">
<meta property="og:site_name" content="{{ $title or 'Potoroze' }}">
<meta property="og:description" content="{{$category->meta_description}}">
<meta property="og:url" content="{{ Request::url()}}">


@endif

<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0">

