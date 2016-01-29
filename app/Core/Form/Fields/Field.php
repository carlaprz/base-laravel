<?php

namespace App\Core\Form\Fields;

interface Field
{

    public function name();

    public function title();

    public function description();

    public function render();
}
