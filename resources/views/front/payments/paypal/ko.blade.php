@extends('front.layouts.master')

@section('content')
<section class="steps" id="end">
    <div class="wrap mini">
        <h2 class="titlelarg">
            {{ trans('msg.cart_error.title') }}
        </h2>

        <p>{{ trans('msg.cart_error.text1') }} <a href="mailto:pedidos@empordaestil.com" style="color: #337ab7;">pedidos@empordaestil.com</a></p><br/><br/>


        <a href="{{ route('cart.step.three') }}"><div class="next" style="float: right;text-transform: uppercase;">{{ trans('msg.cart_error.link') }}</div></a>
    </div>
</section>
@stop

@section('scripts')
<script>$(document).ready(function () {
        $("header").addClass('black');


    });</script>
@endsection