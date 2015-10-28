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
                @if ($errors->count())
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
                <form method="post"
                      action=""
                      @if ($form->isForFiles())
                      enctype="multipart/form-data"
                      @endif
                      >

                      @foreach ($form->fields('generals') as $field)
                      <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                {!! $field->before() !!}
                                {!! $field->render() !!}
                                {!! $field->after() !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @foreach(all_langs() as $languages)
                    @if(null !== ($form->fields($languages->code)))
                    <div class="langueages"> 
                        <div class="lenguages_title active" id="div_title_{{$languages->code}}">
                            <span>Campos en el idioma {{$languages->name}}</span> <a href="#" class="toggle " data-parent="div_title_{{$languages->code}}" data-class='toggle_container_{{$languages->code}}'><span class="fa arrow"></span></a>
                        </div>

                        @foreach ($form->fields($languages->code) as $field)
                        <div class="row toggle_container_{{$languages->code}}" >
                            <div class="col-lg-12">
                                <div class="form-group">
                                    {!! $field->before() !!}
                                    {!! $field->render() !!}
                                    {!! $field->after() !!}
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>    
                    @endif
                    @endforeach

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
                $(elementId + '_prev').val('');
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
      });
</script>
@stop    