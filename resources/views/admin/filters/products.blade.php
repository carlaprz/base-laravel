<div class="panel-heading">
    <form action="" method="post">
        
        <label for="id-filter" >
            <input class="form-control" type="number" name="filters[id]" id="id-filter" value="{{ Session::get('products_filters.id', '') }}"  placeholder="ID" style="width: 5em;"/>
        </label>

        <label for="nombre-filter" >
            <input class="form-control" type="text" name="filters[title]" id="id-filter" value="{{ Session::get('products_filters.title', '') }}"  placeholder="Nombre" style="width: 9em;"/>
        </label>

        <label for="status-filter" >
            <select class="form-control" name="filters[active]" id="status-filter">
                <option value="">Todos los estados</option>
                <option value="0" @if (Session::get('products_filters.active', '') == '0') selected="selected" @endif>Desactivado</option>
                <option value="1" @if (Session::get('products_filters.active', '') == 1) selected="selected" @endif>Activado</option>

            </select>
        </label>
        
        <label for="category-filter">
            <select  class="form-control" name="filters[category_id]" id="secciones-filter">
                <option value="">Todas las categorias</option>
                @foreach (all_categories() as $key => $value)
                @if (Session::get('products_filters.category_id', '') == $key)
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