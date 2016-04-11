<?php

namespace App\Core\Form\Fields;

final class Link extends AbstractField
{

    public function render()
    {
        return '<br> <a href ="' . $this->value() . '" >' . $this->value() . '</a>';
    }

}
