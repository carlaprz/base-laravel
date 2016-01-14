<table class="table table-striped table-bordered table-hover" id="data-table">
    <thead>
        <tr>
            @foreach ($header as $key => $value)
            <th>{{ $value }}</th>
            @endforeach
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $content)
        <tr>
            @foreach ($header as $key => $value)
            <td class="field-{{ $key }}">
                @if ($key == 'active' || $key == 'compress' || $key == 'status')
                {{ $content[$key] ? 'Sí' : 'No' }}
                @elseif (trim($key)=="product_image" || trim($key)=="banner_image" || trim($key)=="image" )
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

                @if ($productsRoute = current_route_has('products'))
                @if($content['products_count']>0)
                <a style="margin-bottom: 2px;" class="btn  btn-small btn-primary" href="{{ route($productsRoute, $content['id']) }}">
                    Productos
                </a>
                @endif
                @endif

                @if ($editComments = current_route_has('editComments'))
                <a class="btn btn-small btn-primary" title="Editar comentarios" href="{{route($editComments,$content['id'])}}">
                    <i class="glyphicon glyphicon-pencil"  > </i>
                </a>
                @endif

                @if ($deleteComments = current_route_has('deleteComments'))
                <a class="delete btn btn-small btn-danger" title="Eliminar comentarios" href="{{ route($deleteComments, $content['id']) }}">
                    <i class="glyphicon glyphicon-trash"> </i>
                </a>
                @endif

                @if ($commentsRoute = current_route_has('comments'))
                @if($content->hasComments())
                <a  style="margin-bottom: 2px;" class="btn  btn-small btn-primary" title="Comentarios" href="{{ route($commentsRoute, $content['id']) }}">
                    Comentarios
                </a>
                @endif
                @endif   
            </td>
        </tr>
        @endforeach

    </tbody>
</table>
