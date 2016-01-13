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
            @if(!isset($details))
                <div class="panel-heading">Completa los campos</div>
            @else
                <div class="panel-heading">Detalle</div>
            @endif
            <div class="panel-body">
                @if (is_object($errors) && $errors->count()>0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>
                            {{ $error }}
                        </li>
                        @endforeach

                    </ul>
                </div>
                @endif
                 @if ($form->isForFiles())
                    <form method="post" action="" enctype="multipart/form-data" > 
                 @else
                    <form method="post" action="" > 
                 @endif
                    @if($form->getDataShow())
                        @foreach($form->getDataShow() as $datashow)
                            <div class="{{$datashow}}">                          
                                <div class="lenguages_title active" id="div_field_{{$datashow}}">
                                    @if($datashow === 'generals')
                                        <span>Datos generales</span> 
                                    @else
                                        <span>Datos "{{$datashow}}" </span>
                                    @endif
                                    <a class="toggle" style="cursor:pointer;" data-parent="div_field_{{$datashow}}" data-class='toggle_field_{{$datashow}}'><span class="fa arrow"></span></a>
                                </div>
                                @foreach ($form->fields($datashow) as $field)
                                    <div class="row toggle_field_{{$datashow}}">
                                      <div class="col-lg-12">
                                          <div class="form-group <?php echo (is_object($field) && get_class($field) == "App\Core\Form\Fields\Datetime")?"datepicker":''; ?>">
                                              {!! $field->before() !!}
                                              {!! $field->render() !!}
                                              {!! $field->after() !!}
                                          </div>
                                      </div>
                                    </div>
                                @endforeach
                            </div> 
                        @endforeach
                   @endif
                    
                    @if(!isset($details))
                        <button class="btn btn-success">Guardar</button>
                    @endif

                    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
                </form>

                @if(isset($delete))
                <form id="deleteForm" action="{{$delete}}">
                    <input type="hidden" name="id" id="id" value="{{$id}}" />
                    <button id="deleteAccion" class="btn btn-danger">DELETE</button>
                </form>
                @endif
            </div>

        </div>
    </div>
</div>
@stop
@section('scripts')
<script>
    $(document).ready(function () {
        $('.deleteImage').on('click', function () {
            if (confirm('Esta seguro de borrar esta Imagen?')) {
                var elementId = '#' + $(this).data('id');
                $(elementId + '_prev').val('');
                $(elementId).html('');
            }
            return false;
        });
        
         $('.deleteFile').on('click', function () {
            if (confirm('Esta seguro de borrar este archivo?')) {
                var elementId = '#' + $(this).data('id');
                var elementdeleteId = '.' + $(this).data('delete');
                console.log(elementdeleteId);
                $(elementdeleteId).val('');
                $(elementId).html('');
                $(elementId+'file').show();
            }
            return false;
        });
        
        @if (isset($delete))
            $('#deleteAccion').on('click', function () {
                    if (confirm('Esta seguro de borrar este Look ?')) {
                        document.location.href = '{{$delete}}';
                    }
                    return false;
            });
        @endif

        @if (isset($changeStatus))
            $("body").on('change', 'select[name=status]', function () {
                $.get("changeStatus/<?php echo $id ?>",
                        {id: <?php echo $id ?>, status: $(this).val()}, function () {
                });
            });
        @endif
        
        @if($form->editor() == true)
            $('.summernote').each(function () {
                    $(this).summernote();
            });
        @endif

         $(document).on('click', '.toggle', function () {
            var element = $(this).data('class');
            var divParent = $(this).data('parent');
            var active = $('#' + divParent).hasClass('active');
            if (active === true) {
                $('#' + divParent).removeClass('active');
            } else {
                $('#' + divParent).addClass('active');
            }
            $('.' + element).toggle('slow');
        });
        
        <?php
        foreach ($form->getDataShow() as $dataHide) {            
            if (null !== $dataHide && $dataHide!== 'generals') { ?>
                if($("#div_field_<?php echo $dataHide?>").length > 0) {
                    $("#div_field_<?php echo $dataHide?> a").trigger("click");
                }
        <?php 
            }
        } ?>
        
        $(document).on('keydown', '.onlyNumbers', function (event) {
            if (event.keyCode == 46 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 27 || event.keyCode == 13 || (event.keyCode == 65 && event.ctrlKey === true) || (event.keyCode >= 35 && event.keyCode <= 39)) {
                return;
            } else {
                if (event.shiftKey || (event.keyCode < 48 || event.keyCode > 57) && (event.keyCode < 96 || event.keyCode > 105)) {
                    event.preventDefault();
                }
            }
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