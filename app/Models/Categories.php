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
    protected $appends = ["es", "en", "parentName"];

    public function getParent()
    {
        return $this->belongsTo(Categories::class, 'parent', 'id')->first();
    }

    public function children()
    {
        return $this->hasMany(Categories::class, 'parent')->get();
    }

    public function getEsAttribute()
    {
        App::setLocale('es');
        return ['title' => $this->title, 'slug' => $this->slug, 'meta_title' => $this->meta_title, 'meta_description' => $this->meta_description];
    }

    public function getEnAttribute()
    {
        App::setLocale('en');
        return ['title' => $this->title, 'slug' => $this->slug, 'meta_title' => $this->meta_title, 'meta_description' => $this->meta_description];
    }

    public function getParentNameAttribute()
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
        return $this->create($data);
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

    public function getChildren()
    {
        return $this->children();
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
