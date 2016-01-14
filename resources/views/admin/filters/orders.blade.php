<div class="panel-heading">
    <form action="" method="post">
        <label for="reference-filter" >
            <input class="form-control" type="text" name="filters[reference]" id="id-filter" value="{{ Session::get('orders_filters.reference', '') }}"  placeholder="Codigo" style="width: 5em;"/>
        </label>
        
        <label for="category-filter">
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
            <select  class="form-control" name="filters[status]" id="secciones-filter">
                <option value="">Medios de pago</option>
                @foreach (all_method_payment() as $key => $value)
                    @if (Session::get('orders_filters.status', '') == $key)
                        <option value="{{ $key }}" selected="selected" >{{ $value }}</option>
                    @else
                        <option value="{{ $key }}" >{{ $value }}</option>
                    @endif
                @endforeach
            </select>
        </label>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input style="margin-bottom: 5px;" class="btn btn-small btn-primary" type="submit" value="Buscar"/>
    </form>
</div>
