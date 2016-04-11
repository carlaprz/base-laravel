@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            {{ $form->name() }} <small>{{ $form->description() }}</small>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">Completa los campos</div>
            
            <div class="panel-body">
               
                <form method="post" action="" enctype="multipart/form-data" > 

                    @if(is_array($form->getDataShow()))

                    @foreach($form->getDataShow() as $datashow )    

                    <div class="{{$datashow["title"]}}">                          
                        
                        @foreach ($form->fields($datashow["title"]) as $field)
                        <div class="row toggle_field_{{$datashow["title"]}}">
                            <div class="col-lg-12">
                                <div class="form-group <?php echo (is_object($field) && get_class($field) == "App\Core\Form\Fields\Datetime") ? "datepicker" : ''; ?>">
                                    {!! $field->before() !!}                                   
                                    {!! $field->render() !!}
                                    {!! $field->after() !!}
                                </div>
                                   <!-- <div class="row">
                                      <div class="col-md-9 docs-buttons">
                                            <div class="btn-group">
                                              <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
                                                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
                                                  <span class="fa fa-arrows"></span>
                                                </span>
                                              </button>
                                              <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
                                                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">
                                                  <span class="fa fa-crop"></span>
                                                </span>
                                              </button>
                                            
                                              <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
                                                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, 0.1)">
                                                  <span class="fa fa-search-plus"></span>
                                                </span>
                                              </button>
                                              <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
                                                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, -0.1)">
                                                  <span class="fa fa-search-minus"></span>
                                                </span>
                                              </button>
                                           
                                              <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
                                                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, -10, 0)">
                                                  <span class="fa fa-arrow-left"></span>
                                                </span>
                                              </button>
                                              <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
                                                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, 10, 0)">
                                                  <span class="fa fa-arrow-right"></span>
                                                </span>
                                              </button>
                                              <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
                                                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, 0, -10)">
                                                  <span class="fa fa-arrow-up"></span>
                                                </span>
                                              </button>
                                              <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
                                                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, 0, 10)">
                                                  <span class="fa fa-arrow-down"></span>
                                                </span>
                                              </button>
                                            
                                              <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
                                                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, -45)">
                                                  <span class="fa fa-rotate-left"></span>
                                                </span>
                                              </button>
                                              <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
                                                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, 45)">
                                                  <span class="fa fa-rotate-right"></span>
                                                </span>
                                              </button>                                          
                                              <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
                                                <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;reset&quot;)">
                                                  <span class="fa fa-refresh"></span>
                                                </span>
                                              </button>
                                        </div>
                                    </div>-->
                            </div> 
                        </div>

                        @endforeach 

                    </div>
                    @endforeach
                    @endif

                    <button class="btn btn-success">Guardar</button>
                             
                    <a  href="{{ route('admin.'.$repository.'.edit', $id)}}" class="btn btn-danger">Cancelar</a>
                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                </form>
            </div>
        </div>
    </div>
</div>
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        @foreach ($form->fields("generals") as $field)
            $("#<?php echo $field->name();?>").cropper({
                aspectRatio: <?php echo isset($filesDimensions[$field->name()]['w'])? $filesDimensions[$field->name()]['w']: '0'?><?php echo isset($filesDimensions[$field->name()]['h'])? '/'.$filesDimensions[$field->name()]['h']: '0'?>,
                crop: function (e) {
                 
                 $("#<?php echo $field->name();?>_x").val(e.x);
                 $("#<?php echo $field->name();?>_y").val(e.y);
                 $("#<?php echo $field->name();?>_w").val(e.width);
                 $("#<?php echo $field->name();?>_h").val(e.height);
                  
                }
            });
           
        @endforeach
    });
</script>
@stop    