<?php

namespace App\Core\Form\Fields;

final class Datetime extends AbstractField
{

    public function render()
    {
        return '<br/> <input type="text" class="form-control" style="width:90%;display:inline" name="' . $this->name() . '" value="' . $this->value() . '"  />
                    <span class="input-group-addon" style="width:10%;display:inline;cursor:pointer;">
                        <span class="glyphicon glyphicon-calendar"></span>
                    </span>';
    }

}
