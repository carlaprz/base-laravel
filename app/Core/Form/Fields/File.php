<?php

namespace App\Core\Form\Fields;

class File extends AbstractField
{

    public function render()
    {
        $data = "";
        $class = "";
        $image = pathinfo($this->value(), PATHINFO_BASENAME);
        $explodeImage = explode('.', $image);

        $id = str_replace('[', '_', $this->name());
        $id = str_replace(']', '_', $id);
        $nameprev = explode(']', $this->name());
        $nameprev = $nameprev[0] . '_prev]';
        if (count($explodeImage) > 1) {

            $data.="<br>
                
                    <input type='hidden' class='{$id}hidden' id='{$nameprev}' name='{$nameprev}' value='" . pathinfo($this->value(), PATHINFO_BASENAME) . "' />
                    <div id='" . $id . "'>
                        Archivo : <a href='{$this->value()}' >" . pathinfo($this->value(), PATHINFO_BASENAME) . "</a>";
            $data.='    <a style="margin-left: 10px;" data-delete="' . $id . 'hidden" data-id="' . $id . '" class="deleteFile btn btn-small btn-danger" title="Eliminar Archivo" >
                            <i class="glyphicon glyphicon-trash"> </i>
                        </a> Eliminar Archivo 
                    </div>';
            $class = 'display:none;';
        }

        $data.= " <input type='file' style='" . $class . "' id='" . $id . "file' name='{$this->name()}'/>  ";

        return $data;
    }

}
