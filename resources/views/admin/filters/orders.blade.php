<div class="panel-heading" style="border:1px solid #ddd; margin:  25px;">
    <div class="panel-heading" style="padding: 5px;">
        Buscador de Pedidos
    </div>
    <form action="" method="post">
        <label for="reference-filter" >
            <input class="form-control" type="text" name="filters[reference]" id="id-filter" value="{{ Session::get('orders_filters.reference', '') }}"  placeholder="Codigo" style="width:6em;"/>
        </label>

        <label for="reference-filter" >
            <input class="form-control" type="text" name="filters[user_name]" id="id-filter" value="{{ Session::get('orders_filters.user_name', '') }}"  placeholder="Cliente" style="width: 5em;"/>
        </label>

        <label for="date-filter" class="datepicker">
            Desde:
            <input type="text" class="form-control" style="width: 10em;display:inline-block;" name="filters[date_start]" placeholder="Fecha desde" value="{{ Session::get('orders_filters.date_start', '') }}"  />
            <span class="input-group-addon" style="width:3em;display:inline-block;cursor:pointer;border:1px solid #ccc">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>

        </label>
        <label for="date-filter" class="datepicker">
            Hasta:
            <input type="text" class="form-control" style="width: 10em;display:inline-block;" name="filters[date_end]" placeholder="Fecha fin" value="{{ Session::get('orders_filters.date_end', '') }}"  />
            <span class="input-group-addon" style="width:3em;display:inline-block;cursor:pointer;border:1px solid #ccc">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </label>
        <label for="status-filter">
            <select  class="form-control" name="filters[status]" id="secciones-filter">
                <option value="">Todas los estados</option>
                @foreach (orders_status() as $key => $value)
                @if (Session::get('orders_filters.status', '') == $key)
                <option value="{{ $key }}" selected="selected" >{{ $value }}</option>
                @else
                <option value="{{ $key }}" >{{ $value }}</option>
                @endif
                @endforeach
            </select>
        </label>

        <label for="category-filter">
            <select  class="form-control" name="filters[payment_id]" id="secciones-filter">
                <option value="">Medios de pago</option>
                @foreach (all_method_payment() as $key => $value)
                @if (Session::get('orders_filters.payment_id', '') == $key)
                <option value="{{ $key }}" selected="selected" >{{ $value }}</option>
                @else
                <option value="{{ $key }}" >{{ $value }}</option>
                @endif
                @endforeach
            </select>
        </label>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input class="btn btn-small btn-primary" type="submit" value="Buscar"/>
        <a href="{{ route('admin.orders.remove_filters') }}" class="btn btn-primary">Borrar Filtros</a>

    </form>
</div>
