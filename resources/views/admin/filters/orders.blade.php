<div class="panel-heading  panel-buscador">
    <div class="panel-heading buscador-interior">
        <span>Filtrado de pedidos</span>
    </div>
    <form class="pedidos" action="" method="post">
        <label for="date-filter" class="datepicker">

            <input type="text" class="form-control" name="filters[date_start]" placeholder="Fecha desde..." value="{{ Session::get('orders_filters.date_start', '') }}"  />
            <span class="calendar-button">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </label>
        <label for="date-filter" class="datepicker">

            <input type="text" class="form-control" name="filters[date_end]" placeholder="Fecha hasta..." value="{{ Session::get('orders_filters.date_end', '') }}"  />
            <span class="calendar-button">
                <span class="glyphicon glyphicon-calendar"></span>
            </span>
        </label>

        <label for="reference-filter" >
            <input class="form-control" type="text" name="filters[reference]" id="id-filter" value="{{ Session::get('orders_filters.reference', '') }}"  placeholder="Código" style="width:8em;"/>
        </label>

        <label for="reference-filter" >
            <input class="form-control" type="text" name="filters[user_name]" id="id-filter" value="{{ Session::get('orders_filters.user_name', '') }}"  placeholder="Cliente" style="width: 12em;"/>
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
                <option value="">Formas de pago</option>
                @foreach (all_method_payment() as $key => $value)
                    @if (Session::get('orders_filters.payment_id', '') == $key)
                        <option value="{{ $key }}" selected="selected" >{{ $value }}</option>
                    @else
                        <option value="{{ $key }}" >{{ $value }}</option>
                    @endif
                @endforeach
            </select>
        </label>
        <div class="buttons">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input class="btn btn-small btn-primary" type="submit" value="Filtrar"/>
            <a href="{{ route('admin.orders.remove_filters') }}" class="btn btn-primary red">Borrar Filtros</a>
       </div>
    </form>
</div>
