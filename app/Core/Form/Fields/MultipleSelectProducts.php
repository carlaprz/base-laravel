<?php

namespace App\Core\Form\Fields;

final class MultipleSelectProducts extends AbstractField
{

    public function render()
    {
        $options = $this->generateOptions();
        return "<select class='form-control' name='{$this->name()}[]' multiple>{$options}</select>";
    }

    private function generateOptions()
    {
        $data = $this->description();
        $data = $data();
        $options = "<option value=''>Seleciona</option>";

        foreach ($data as $categories) {

            $options .= " <optgroup label='{$categories['name']}'>";
            if (!empty($categories['products'])) {
                foreach ($categories['products'] as $productId => $productName) {
                    if (!empty($productId) && !empty($productName)) {
                        $selected = '';
                        if (is_array($this->value()) && in_array($productId, $this->value())) {
                            $selected = 'selected="selected"';
                        }
                        $options .= "<option value='{$productId}' {$selected}> &nbsp;{$productName}</option>";
                    }
                }
            }
            $options.="</optgroup>";

            if (!empty($categories['child'])) {
                foreach ($categories['child'] as $children) {
                    if (count($children['products']) > 0) {
                        $options .= "<optgroup label='&nbsp;&nbsp;{$children['name']}'>";
                        foreach ($children['products'] as $childrenProductId => $childrenProductName) {
                            if (!empty($childrenProductId) && !empty($childrenProductName)) {
                                $selected = '';
                                if (is_array($this->value()) && in_array($childrenProductId, $this->value())) {
                                    $selected = 'selected="selected"';
                                }
                                $options .= "
                                    <option
                                    value='{$childrenProductId}'
                                    {$selected}>
                                    &nbsp;{$childrenProductName}</option>";
                            }
                        }
                        $options.="</optgroup>";
                    }
                }
            }
        }

        return $options;
    }

}
