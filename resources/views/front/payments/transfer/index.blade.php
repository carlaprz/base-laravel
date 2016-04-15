@extends('front.layouts.master')

@section('content')
<section class="steps" id="end">
    <div class="wrap mini">
        <h2 class="titlelarg">
            {{ trans('msg.cart_end.title') }}
        </h2>

        <p>{{ trans('msg.cart_end.text1') }}, la referencia de este pedido es <b>{{ $reference }}</b>. </p><br/>
        <p>{{ trans('msg.cart_end.text2') }} de tu compra ({{number_format($total)}} €) al siguiente número de cuenta: <br/> ES86 2100 0002 5802 0179 0328</p><br/>
        <p>{{ trans('msg.cart_end.text3') }}<a style="color: #337ab7;" href="mailto:{{ trans('msg.cart_end.text4') }}?subject=Pedido numero {{ $reference }}, comprobante de pago">{{ trans('msg.cart_end.text4') }}</a></p><br/>
        <p>{{ trans('msg.cart_end.text5') }} <b></b></p><br/><br/>
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
