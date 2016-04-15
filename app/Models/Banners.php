<?php

namespace App\Models;

use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class Banners extends Model implements ModelInterface
{

    const IMAGE_PATH = 'files/banners/';

    protected $fillable = ['name', 'text', 'link', 'image', 'order', 'active'];

    public function add( $data )
    {
        return $this->create($data);
    }

    //Metodos FRONT
    public function findAllActive()
    {
        return $this
                        ->where('active', '=', 1)
                        ->orderby('order', 'ASC')
                        ->get();
    }

    public function getImageAttribute( $image )
    {
        return (filter_var($image, FILTER_VALIDATE_URL) === FALSE) ? $this->imagePath($image) : $image;
    }

    private function imagePath( $image )
    {
        if (!empty($image)) {
            return asset(self::IMAGE_PATH . $image);
        }
        return false;
    }

}
