<?php

namespace App\Core\Form\Fields;

final class Textarea extends AbstractField
{

    public function render()
    {
        return "<textarea class='form-control summernote'
                          rows='5'
                          name='{$this->name()}'
                          placeholder='{$this->description()}'>{$this->value()}</textarea>
        ";
    }

}
