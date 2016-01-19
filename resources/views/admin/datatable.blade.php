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
    <div class="col-md-12">
    @if ($createRoute = current_route_has_create())
        <a href="{{ route($createRoute) }}"
           class="btn btn-primary">Crear nuevo</a>
    @endif

    @if ($excelRoute = current_route_has('excel'))
        <a href="{{ route($excelRoute) }}"
           class="btn btn-primary">Exportar a Excel</a>
    @endif
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
                    @include('admin/partials/datatable')
                    @if (isset($totalProductsPerPage))
                    {!! $data->render() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script>
    $(document).ready(function (){
            @if (!isset($noDataTable))
                    $('#data-table').dataTable({
            'pageLength': 30,
                    @if (isset($flux))
                    "order": [[ 3, "desc" ]],
                    @ else
                    "order": [[ 0, "desc" ]],
                    @endif
                    @if (isset($totalProductsPerPage))
                    "paging": false,
                    "searching": false
                    @endif
            });
                    @endif

            $('.delete').on('click', function () {
                if (confirm('Está seguro de borrar este contenido?')) {
                    return true;
                    }
                    return false;
            });
            
            $(document).on('click', '.datepicker', function () {
                $(this).datetimepicker({
                   format: 'YYYY-MM-DD HH:mm' ,
                   use24hours: true               
                });
            });
    });
</script>

@stop
