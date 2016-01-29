<?php

namespace App\Core\Form\Fields;

final class Hidden extends AbstractField
{

    public function render()
    {
        return "<input class='form-control'
                       type='hidden'
                       name='{$this->name()}'
                       value='{$this->value()}'>
           ";
    }

}
