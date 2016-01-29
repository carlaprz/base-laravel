<?php

namespace App\Core\Form\Fields;

final class NumericDisabled extends AbstractField
{

    public function render()
    {
        return "
            <input class='form-control'
                   placeholder='{$this->description()}'
                   name='{$this->name()}'
                   value='{$this->value()}'
                   disabled
            >
        ";
    }

}
