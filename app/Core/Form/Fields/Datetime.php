<?php

namespace App\Core\Form\Fields;

final class Datetime extends AbstractField
{

    public function render()
    {
        return '<br/> <input type="text" class="form-control" style="width:12em;display:inline" name="' . $this->name() . '" value="' . $this->value() . '"  />
                    <span class="calendar-button">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>';
    }

}
