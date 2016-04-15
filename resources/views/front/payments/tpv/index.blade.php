@extends('front.layouts.master')

@section('content')
<section class="steps" id="end">
    <div class="wrap mini">
        <h2 class="titlelarg">
            {{ trans('msg.cart_end.title') }}
        </h2>

        <p>{{ trans('msg.cart_end.text9') }}</p>

        {!! $formTPV !!}

    </div>
</section>
@stop

@section('scripts')
<script>$(document).ready(function () {
        $("header").addClass('black');
        $("#tpvform").submit();
    });</script>
@endsection