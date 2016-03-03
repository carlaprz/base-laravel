@extends('front.layouts.master')

@section('content')
<section class="steps" id="end">
    <div class="wrap mini">
        <h2 class="titlelarg">
            {{ trans('msg.cart_end.title') }}
        </h2>

        <p>{{ trans('msg.cart_end.text8') }}</p><br/><br/>
        <p>{{ trans('msg.cart_end.text6') }}</p>


        <a href="{{ route('home') }}"><div class="next" style="float: right;text-transform: uppercase;">{{ trans('msg.cart_end.text7') }}</div></a>
    </div>
</section>
@stop

@section('scripts')
<script>$(document).ready(function () {
        $("header").addClass('black');

    });</script>
@endsection