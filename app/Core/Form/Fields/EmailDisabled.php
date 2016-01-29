<?php

namespace App\Core\Form\Fields;

final class EmailDisabled extends AbstractField
{

    public function render()
    {
        return "<div class='.form-group input-group'>
                <span class='input-group-addon'>@</span>
                <input  type='text'
                        class='form-control'
                        name='{$this->name()}'
                        value='{$this->value()}'
                        placeholder='{$this->description()}'
                        disabled>
                </div>";
    }

}
