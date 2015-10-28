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

@if ($createRoute = current_route_has_create())
<div class="row">
    <div class="col-md-12">
        <a href="{{ route($createRoute) }}"
           class="btn btn-primary">Crear nuevo</a>
    </div>
</div>
<div class="row">
    <br/>
</div>
@endif

<div class="row">
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ $pageTitle }}
            </div>
            @if ($excelRoute = current_route_has('excel'))
                 <a href="{{ route($excelRoute) }}">Descargar Excel</a> 
            @endif
            
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
        $('#data-table').dataTable({
            'pageLength': 30,
            @if (isset($flux))
             "order": [[ 3, "desc" ]],
            @else
                "order": [[ 0, "desc" ]],
            @endif
            @if (isset($totalProductsPerPage))
                "paging": false,
                "searching": false
            @endif
        });
    
        $('.delete').on('click', function () {
            if (confirm('Esta seguro de borrar este contenido?')) {
                return true;
            }
            return false;
        });
    });
</script>

@stop
