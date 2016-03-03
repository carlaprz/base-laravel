<?php

namespace App\Core\Form\Fields;

final class Text extends AbstractField
{

    public function render()
    {
        $value = !is_array($this->value()) ? $this->value() : "";
        return "<input class='form-control'
                       placeholder='{$this->description()}'
                       name='{$this->name()}'
                       value='$value'>
           ";
    }

}
