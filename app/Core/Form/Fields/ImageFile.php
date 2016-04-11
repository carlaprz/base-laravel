<?php

namespace App\Core\Form\Fields;

use Request;

class ImageFile extends AbstractField
{

    public function render( $id = null )
    {
        $id = Request::url();
        $id = explode("/", $id);
        $id = $id[count($id) - 1];


        $repo = pathinfo($this->value(), PATHINFO_DIRNAME);
        $repo = explode("/", $repo);
        $repo = $repo[count($repo) - 1];

        $image = pathinfo($this->value(), PATHINFO_BASENAME);

        $explodeImage = explode('.', $image);

        if (count($explodeImage) > 1) {
            $data = "<input type='file' style='display:none' id='{$this->name()}_input' name='{$this->name()}'/> 
                     <input type='hidden' id='{$this->name()}_prev' name='{$this->name()}_prev' value='" . pathinfo($this->value(), PATHINFO_BASENAME) . "' />
                     <br/>
                     <div id='{$this->name()}'>
                        <img style='border: 1px solid #000' src='{$this->value()}'>";

            $data.='<a style="margin-left: 10px;" data-id="' . $this->name() . '" class="deleteImage btn btn-small btn-danger" title="Eliminar Imagen" >
                        <i class="glyphicon glyphicon-trash"> </i>
                    </a> Eliminar 
                    <a style="margin-left: 10px;" data-id="' . $this->name() . '" href="' . route("admin." . $repo . '.crop', $id) . '" target="_blank" class="btn btn-small btn-danger" title="Editar Imagen" >
                        <i class="glyphicon glyphicon-pencil"> </i>
                    </a> Editar 
                    </div>';
        } else {
            $data = "<input type='file' name='{$this->name()}'/> ";
            $data.="<input type='hidden' name='{$this->name()}_prev' value='' />";
        }

        return $data;
    }

}
