<?php

namespace App\Models;

use App;
use DB;
use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class Categories extends Model implements ModelInterface
{

    use \Dimsav\Translatable\Translatable;

    public $timestamps = true;
    public $translatedAttributes = [ 'title', 'meta_title', 'meta_description', 'slug'];
    protected $fillable = ['parent', 'active', 'title', 'meta_title', 'meta_description', 'slug'];
    protected $appends = ["es", "en", "fr", "parentName"];

    public function getParent()
    {
        return $this->belongsTo(Categories::class, 'parent', 'id')->first();
    }

    public function getChildren()
    {
        return $this->hasMany(Categories::class, 'parent')->get();
    }

    public function getEsAttribute()
    {
        App::setLocale('es');
        return ['title' => $this->title, 'meta_title' => $this->meta_title, 'meta_description' => $this->meta_description];
    }

    public function getEnAttribute()
    {
        App::setLocale('en');
        return ['title' => $this->title, 'meta_title' => $this->meta_title, 'meta_description' => $this->meta_description];
    }

    public function getFrAttribute()
    {
        App::setLocale('fr');
        return ['title' => $this->title, 'meta_title' => $this->meta_title, 'meta_description' => $this->meta_description];
    }

    public function getparentNameAttribute()
    {
        App::setLocale('es');
        $parent = $this->getParent();
        if (isset($parent)) {
            return $parent->title;
        }
        return '---';
    }

    //ALL
    public function add( $data )
    {
        
    }

    public function addBeforeValidation( $data, $rules )
    {
        $validated = $this->validate($data, false, $rules);
        if ($validated['error'] == false) {
            return $this->create($data);
        } else {
            return $validated;
        }
    }

    public function updateBeforeValidation( $data, $id, $rules )
    {
        $validated = $this->validate($data, $id, $rules);
        if ($validated['error'] == false) {
            return $this->update($data);
        } else {
            return $validated;
        }
    }

    private function validate( $data, $id = null, $rules )
    {

        $langs = all_langs();
        $errors = [];


        foreach ($rules as $key => $value) {

            if (is_array($value)) {
                foreach ($value as $field => $rule) {
                    if ($rule == 'required') {
                        if (empty($data[$key][$field])) {
                            $text = $field;
                            if ($field == 'title') {
                                $text = 'nombre';
                            }
                            $errors['error'][] = 'El campo ' . $text . ' en el idioma "' . strtoupper($key) . '" es obligatorio.';
                        }
                    }
                }
            } else {
                if ($value == 'required') {
                    if (isset($data[$key]) && empty($data[$key])) {
                        $text = $key;
                        if ($key == 'category_id') {
                            $text = 'categoria';
                        }

                        $errors['error'][] = 'El campo ' . $text . ' es obligatorio.';
                    }
                }
            }
        }

        $queryValidation = $this->select('*')->join(DB::raw('categories_translations ct'), 'ct.categories_id', '=', 'categories.id');
        foreach ($langs as $lang) {
            if (isset($data[$lang->code]) && isset($data[$lang->code]['title'])) {
                $queryValidation = $queryValidation->orWhere(function($query) use( $lang, $data, $id)
                {
                    $query = $query->where('ct.locale', '=', $lang->code)
                            ->Where('ct.title', '=', $data[$lang->code]['title']);
                    if (isset($data[$lang->code]['parent'])) {
                        $query = $query->Where('ct.parent', '=', $data[$lang->code]['parent']);
                    }
                    return $query;
                });
            }
        }

        if (isset($id)) {
            $queryValidation = $queryValidation->where('ct.categories_id', '<>', $id);
        }

        $data = $queryValidation->get();

        if (count($data) > 0) {
            $errors['error'][] = 'Ya existe una categoria con ese Nombre.';
            return $errors;
        }

        if (!empty($errors)) {
            return $errors;
        }

        return true;
    }

    public function parents()
    {
        return $this->where('parent', '=', 0)->get();
    }

    public function childs()
    {
        return $this->where('parent', '<>', 0)->get();
    }

    public function childsByParent( $id )
    {
        return $this->where('parent', '=', $id)
                        ->where('active', '=', 1)
                        ->get();
    }

    public function children()
    {
        return $this->getChildren();
    }

    public function findCategoryBySlug( $slug )
    {
        return $this->select('categories.*')
                        ->join(DB::raw('categories_translations ct'), 'ct.categories_id', '=', 'categories.id')
                        ->where('categories.active', '=', 1)
                        ->where('ct.slug', $slug)
                        ->first();
    }

    public function findCategoryById( $id )
    {
        return $this->select('categories.*')
                        ->join(DB::raw('categories_translations ct'), 'ct.categories_id', '=', 'categories.id')
                        ->where('categories.active', '=', 1)
                        ->where('categories.id', $id)
                        ->get();
    }

    public function findparentsactive()
    {
        return $this->where('parent', '=', 0)
                        ->where('active', '=', 1)
                        ->get();
    }

}
