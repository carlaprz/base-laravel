<?php namespace App\Core\Form\Fields;

final class URLImage extends Image
{
    public function render()
    {
        $image = parent::render();

        return "<input class='form-control'
                       placeholder='{$this->description()}'
                       name='{$this->name()}'
                       value='{$this->value()}'>" . $image;
    }
}
