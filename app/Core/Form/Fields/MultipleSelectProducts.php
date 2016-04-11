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
        $dataFunction = $this->description();
        $data = $dataFunction();

        $options = "<option>Seleciona</option>";

        $options .= $this->generateParentsOpcions($data);

        return $options;
    }

    private function generateParentsOpcions( $data )
    {
        $return = "";

        foreach ($data as $categories) {
            $return .= " <optgroup label='{$categories['name']}'>";
            foreach ($categories['products'] as $productId => $productName) {
                $selected = is_array($this->value()) && in_array($productId, $this->value()) ? 'selected="selected"' : null;
                $return .= "<option value='{$productId}' {$selected}> &nbsp;{$productName}</option>";
            }
            $return.="</optgroup>";

            if (!empty($categories['child'])) {
                $return .= $this->generateChildsOptions($categories['child']);
            }
        }

        return $return;
    }

    private function generateChildsOptions( $categories )
    {
        $return = "";

        if (!empty($categories) && is_array($categories)) {
            foreach ($categories as $children) {
                $return .= "<optgroup label='&nbsp;&nbsp;{$children['name']}'>";

                foreach ($children['products'] as $childrenProductId => $childrenProductName) {
                    $selected = is_array($this->value()) && in_array($childrenProductId, $this->value()) ? 'selected="selected"' : null;
                    $return .= "<option value='{$childrenProductId}' {$selected}>&nbsp;{$childrenProductName}</option>";
                }

                $return.="</optgroup>";
            }
        }
        return $return;
    }

}
