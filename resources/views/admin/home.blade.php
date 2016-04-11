@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            Hitecsa <small>Estadisticas</small>
        </h1>
    </div>
</div>
<!-- /. ROW  -->

<div class="row">
    <div class="col-md-3 col-sm-12 col-xs-12">
        <a href="{{route('admin.products.index')}}" style="color:#FFF">
            <div class="panel panel-primary text-center no-boder bg-color-green">
                <div class="panel-body">
                    <i class="fa fa-shopping-cart fa-5x"></i>
                    <h3>{{$cant['products']}}</h3>
                </div>
                <div class="panel-footer back-footer-green">
                    Productos
                </div>
            </div>
        </a>
    </div>
    <div class="col-md-3 col-sm-12 col-xs-12">
        <a href="{{route('admin.categories.index')}}" style="color:#FFF">
            <div class="panel panel-primary text-center no-boder bg-color-blue">
                <div class="panel-body">
                    <i class="fa fa-align-left fa-5x"></i>
                    <h3>{{$cant['categories']}}</h3>
                </div>
                <div class="panel-footer back-footer-blue">
                    Categorias

                </div>
            </div>
        </a>

    </div>
    
    <div class="col-md-3 col-sm-12 col-xs-12">
        <a href="{{route('admin.news.index')}}" style="color:#FFF">
            <div class="panel panel-primary text-center no-boder bg-color-red">
                <div class="panel-body">
                    <i class="fa fa fa-bullhorn  fa-5x"></i>
                    <h3>{{$cant['news']}}</h3>
                </div>
                <div class="panel-footer back-footer-red">
                    Noticias

                </div>
            </div>
        </a>
    </div>
</div>

@stop
