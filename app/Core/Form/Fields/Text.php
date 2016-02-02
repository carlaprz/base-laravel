<?php

namespace App\Core\Form\Fields;

final class Text extends AbstractField
{

    public function render()
    {       
        return "<input class='form-control'
                       placeholder='{$this->description()}'
                       name='{$this->name()}'
                       value='{$this->value()}'>
           ";
    }

}
