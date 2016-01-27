@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            @if(isset($title))
            {{ $title }}
            @else
            {{ last_word($pageTitle) }}
            @endif
        </h1>
    </div>
</div>

<div class="row">
    <br/>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $pageTitle }}
            </div>
            @if (isset($extras))
            @foreach ($extras as $extra)
            @include($extra)
            @endforeach
            @endif
            <div class="panel-body">
                <div class="table-responsive">
                    @include('admin/partials/order')                    
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script>
    $(document).ready(function () {
        var adjustment;

        $("#sorteabled").sortable();
        $('#save').on('click', function () {
            order = new Array;
            $('#sorteabled li').each(function (key, value) {
                var me = $(value);
                var id = me.data('id');
                order.push(id);
            });
            $('#order_input').val(order);
            $('#saveOrder').submit();
        });
    });
</script>

@stop
