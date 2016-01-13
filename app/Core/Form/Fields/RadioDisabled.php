<?php

namespace App\Core\Form\Fields;

final class RadioDisabled extends AbstractField
{

    public function render()
    {
        $checked = "checked='checked'";

        $trueValue = $this->value() ? $checked : '';
        $falseValue = $this->value() ? '' : $checked;

        return "
            &nbsp;&nbsp;
            <label for='r-1'>
                <span>Sí</span>
                <input type='radio'
                       id='r-1'
                       name='{$this->name()}'
                       value='1'
                       {$trueValue}
                      disabled />
            </label>
            &nbsp;&nbsp;
            <label for='r-2'>
                <span>No</span>
                <input type='radio'
                       id='r-2'
                       name='{$this->name()}'
                       value='0'
                       {$falseValue}
                     disabled  />
            </label>
        ";
    }

}
