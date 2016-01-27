<?php $cantTd = 0; ?>
<table class="table table-striped table-bordered table-hover" id="data-table">
    <thead>
        <tr>
            @foreach ($header as $key => $value)
            <?php $cantTd++; ?>
            <th>{{ $value }}</th>
            @endforeach
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $content)
        <tr>
            @foreach ($header as $key => $value)
            <td class="field-{{ $key }}">
                @if ($key == 'active' || $key == 'compress' || $key == 'status')
                {{ $content[$key] ? 'Sí' : 'No' }}
                @elseif (trim($key)=="product_image" || trim($key)=="banner_image" || trim($key)=="image" || trim($key)=="thumb" )
                <?php
                $image = pathinfo($content[$key], PATHINFO_BASENAME);
                $explodeImage = explode('.', $image);
                ?>
                @if(count($explodeImage)>1)
                <div style="text-align: center;"><img src="{{$content[$key]}}" width="50px"></div>
                @endif        
                @else
                {!! $content[$key] !!}
                @endif
            </td>
            @endforeach

            <td>        

                @if ($editRoute = current_route_has_edit())
                <a class="btn btn-small btn-primary" title="Editar" href="{{ route($editRoute, $content['id']) }}">
                    <i class="glyphicon glyphicon-pencil"  > </i>
                </a>
                @endif

                @if ($deleteRoute = current_route_has_delete())
                <a class="delete btn btn-small btn-danger" title="Eliminar" href="{{ route($deleteRoute, $content['id']) }}">
                    <i class="glyphicon glyphicon-trash"> </i>
                </a>
                @endif

                @if ($detailsRoute = current_route_has('details'))
                <a class="btn  btn-small btn-primary" title="Detalle" href="{{ route($detailsRoute, $content['id']) }}">
                    <i class="glyphicon glyphicon-list-alt"  > </i>
                </a>
                @endif

                @if ($billRoute = current_route_has('bill'))
                <a class="btn btn-small btn-primary" title="Factura" href="{{route($billRoute,$content['id'])}}">
                    <i class="glyphicon glyphicon-print"  > </i>
                </a>
                @endif

                @if ($changeStatus = current_route_has('editstatus'))
                <a class="btn btn-small btn-primary" title="Cambiar estado" href="{{route($changeStatus,$content['id'])}}">
                    <i class="glyphicon glyphicon-pencil"  > </i>
                </a>
                @endif

            </td>
        </tr>
        @empty
            @if (isset($noDataTable))
            <tr class="odd"> <td colspan="<?php echo $cantTd+1;?>" valing="top" class="dataTables_empty">No se encontraron resultados.</td></tr>
            @endif
        @endforelse

    </tbody>
</table>
