<?php

namespace App\Models;

use App;
use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class Colours extends Model implements ModelInterface
{

    use \Dimsav\Translatable\Translatable;

    protected $table = 'colours';
    public $translatedAttributes = ['title'];
    protected $fillable = ['active', 'title'];
    protected $appends = ["es", "en"];

    public function getEsAttribute()
    {
        App::setLocale('es');
        return ['title' => $this->title];
    }

    public function getEnAttribute()
    {
        App::setLocale('en');
        return ['title' => $this->title];
    }

    public function add( $data )
    {
        return $this->create($data);
    }

}
