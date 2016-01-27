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
        <li style="padding: 0px; border: 0px; color: #555;background: none;  cursor:none;">No se encontraron resultados.</li>
    @endforelse
</ol>

<a id="save" class="btn btn-success">Guardar</a>
<a  href="{{route('admin.'.$repository.'.index')}}" class="btn btn-danger">Cancelar</a>

<form id="saveOrder" action="{{route('admin.'.$repository.'.orderSave')}}" method="post" >
    <input type="hidden" name="order" id="order_input" value="" />
    <input type="hidden" name="_token" id="csrf-token" value="{{ Session::token() }}" />
</form>