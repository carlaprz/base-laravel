<div class="panel-heading">
    <form action="" method="post">
        <br/>
        <label for="category-filter">
            <select  class="form-control" name="filters[section_id]" id="secciones-filter">
                <option value="">Todas las secciones</option>
                @foreach (all_section_list() as $key => $value)
                <option value="{{ $key }}"
                        @if (Session::get('sections_filters.section_id', '') == $key) selected="selected" @endif
                        >{{ $value }}</option>
                @endforeach
            </select>
        </label>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input style="margin-bottom: 5px;" class="btn btn-small btn-primary" type="submit" value="Buscar"/>
    </form>
</div>
