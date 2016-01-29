<?php

namespace App\Core\Form\Fields;

class Image extends AbstractField
{

    public function render()
    {
        return "
            <br><img src='{$this->value()}' style='max-width: 300px;'>
        ";
    }

}
