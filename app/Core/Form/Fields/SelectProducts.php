<?php

namespace App\Core\Form\Fields;

final class SelectProducts extends AbstractField
{

    public function render()
    {
        $options = $this->generateOptions();
        return "<select class='form-control' name='{$this->name()}'>{$options}</select>";
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
                        if ($productId == $this->value()) {
                            $selected = 'selected="selected"';
                        }
                        $options .= "<option value='{$productId}' {$selected}> &nbsp;{$productName}</option>";
                    }
                }
            }
            $options.="</optgroup>";

            if (!empty($categories['child'])) {
                foreach ($categories['child'] as $children) {
                    $options .= "<optgroup label='&nbsp;&nbsp;{$children['name']}'>";
                    foreach ($children['products'] as $childrenProductId => $childrenProductName) {
                        if (!empty($childrenProductId) && !empty($childrenProductName)) {
                            $selected = '';
                            if ($childrenProductId == $this->value()) {
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

        return $options;
    }

}
