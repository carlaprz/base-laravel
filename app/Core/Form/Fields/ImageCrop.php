<?php

namespace App\Core\Form\Fields;

class ImageCrop extends AbstractField
{

    public function render()
    {
        if ($this->value()) {
            $data = " ";
            $image = pathinfo($this->value(), PATHINFO_BASENAME);
            $explodeImage = explode('.', $image);
            if (count($explodeImage) > 1) {
                $data.="<br>
                    <input type='hidden' id='{$this->name()}_input' name='{$this->name()}[name]' value='" . pathinfo($this->value(), PATHINFO_BASENAME) . "' />
                    <div>
                        <img id='{$this->name()}' src='{$this->value()}' > 
                        <input type='hidden' id='{$this->name()}_x' name='{$this->name()}[x]' value='' >
                        <input type='hidden' id='{$this->name()}_y' name='{$this->name()}[y]' value='' >
                        <input type='hidden' id='{$this->name()}_h' name='{$this->name()}[h]' value='' >
                        <input type='hidden' id='{$this->name()}_w' name='{$this->name()}[w]' value='' >";
                $data.=' </div>';
            }

            return $data;
        } else {
            return "<br/>No hay imagen relacionada para recortar.<br/>";
        }
    }

}
