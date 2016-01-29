<?php namespace App\Core\Form\Fields;

final class Select extends AbstractField
{
    public function render()
    {
        $options = $this->generateOptions();

        return "<select class='form-control' name='{$this->name()}'>{$options}</select>";
    }

    private function generateOptions()
    {
        $dataFunction = $this->description();
        $data = $dataFunction();

        $data[0] = 'Selecciona';
        
        $options = '';
        foreach ($data as $key => $name) {
            $selected = '';
            if ($key == $this->value()) {
                $selected = 'selected="selected"';
            }
            $value = $key!=0?$key:"";
            $options .= "
                <option
                value='{$value}'
                {$selected}>
                {$name}</option>
            ";
        }

        return $options;

    }

}
