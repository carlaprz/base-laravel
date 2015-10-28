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
        $validated = $this->validate($data);
        if ($validated['error'] == false) {
            return $this->create($data);
        } else {
            return $validated;
        }
    }

    public function updateBeforeValidation( $data, $id )
    {
        $validated = $this->validate($data, $id);
        if ($validated['error'] == false) {
            return $this->update($data);
        } else {
            return $validated;
        }
    }

    private function validate( $data, $id = null )
    {
        $langs = all_langs();
        $errors = [];

        if (key_exists('es', $data)) {
            if ($data['es']['title'] == '') {
                $errors['error'][] = 'El campo titulo en español es obligatorio.';
                return $errors;
            }
        }

        $queryValidation = $this->select('*')->join(DB::raw('categories_translations ct'), 'ct.categories_id', '=', 'categories.id');

        foreach ($langs as $lang) {
            if (isset($data[$lang->code]['title'])) {
                $queryValidation = $queryValidation->orWhere(function($query) use( $lang, $data, $id)
                {
                    $query = $query->where('ct.locale', '=', $lang->code)
                            ->Where('ct.title', '=', $data[$lang->code]['title']);
                    if (isset($data[$lang->code]['parent'])){
                        $query = $query->Where('ct.parent', '=', $data[$lang->code]['parent']);
                    }

                    if (isset($id)) {
                        $query = $query->where('ct.categories_id', '<>', $id);
                    }
                    return $query;
                });
            }
        }

        $data = $queryValidation->get();
        if (count($data) > 0) {
            $errors['error'][] = 'Ya existe una categoria con ese titulo.';
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
        return $this->where('parent', '=', $id)->get();
    }

    public function findCategoryBySlug( $slug )
    {
        return $this->select('categories.*')
                        ->join(DB::raw('categories_translations ct'), 'ct.categories_id', '=', 'categories.id')
                        ->where('categories.active', '=', 1)
                        ->where('ct.slug', $slug)
                        ->get();
    }

    public function findparentsactive()
    {
        return $this->where('parent', '=', 0)
                        ->where('active', '=', 1)
                        ->get();
    }

}
