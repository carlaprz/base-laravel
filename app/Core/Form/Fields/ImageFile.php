<?php

namespace App\Core\Form\Fields;

use Request;

class ImageFile extends AbstractField
{

    public function render( $id = null )
    {

        $data = " <input type='file' name='{$this->name()}'/> ";
        $id = Request::url();
        $id = explode("/", $id);
        $id = $id[count($id) - 1];


        $repo = pathinfo($this->value(), PATHINFO_DIRNAME);
        $repo = explode("/", $repo);
        $repo = $repo[count($repo) - 1];

        $image = pathinfo($this->value(), PATHINFO_BASENAME);

        $explodeImage = explode('.', $image);

        if (count($explodeImage) > 1) {
            echo 'caca';
            $data.="<br>
                    <input type='hidden' id='{$this->name()}_prev' name='{$this->name()}_prev' value='" . pathinfo($this->value(), PATHINFO_BASENAME) . "' />
                    <div id='{$this->name()}'>
                        <img  src='{$this->value()}' style='max-width: 300px;'>";

            $data.='<a style="margin-left: 10px;" data-id="' . $this->name() . '" class="deleteImage btn btn-small btn-danger" title="Eliminar Imagen" >
                        <i class="glyphicon glyphicon-trash"> </i>
                    </a> Eliminar Imagen 
                    <a style="margin-left: 10px;" data-id="' . $this->name() . '" href="' . route("admin." . $repo . '.crop', $id) . '" target="_blank" class="btn btn-small btn-danger" title="Editar Imagen" >
                        <i class="glyphicon glyphicon-pencil"> </i>
                    </a> Editar 
                    </div>';
        } else {
            $data.=" <input type='hidden' name='{$this->name()}_prev' value='' />";
        }

        return $data;
    }

}
