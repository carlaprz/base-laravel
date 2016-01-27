<?php $cantTd = 0; ?>
<ol class="sorteabled simple_with_animation vertical" id="sorteabled">
    @forelse ($data as $content)
    <li data-id="{{$content['id']}}">
        @foreach ($header as $key => $value)
        {!! $content[$key] !!}
        @endforeach
        <?php $cantTd++; ?>
    </li >
    @empty
    @if (isset($noDataTable))
    <li >No se encontraron resultados.</li>
    @endif
    @endforelse
</ol>
<?php
$url = explode("/", Request::url());
$repo = $url[count($url) - 2];
?>  
<a id="save" class="btn btn-success">Guardar</a>
<a  href="{{route('admin.'.$repo.'.index')}}" class="btn btn-danger">Cancelar</a>

<form id="saveOrder" action="{{route('admin.'.$repo.'.orderSave')}}" method="post" >
    <input type="hidden" name="order" id="order_input" value="" />
    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
</form>