<?php

namespace App\Core\Form\Fields;

use Session;

abstract class AbstractField implements Field
{

    private $name;
    private $title;
    private $description;
    private $value;
    private $rules;

    public function __construct( $name, $title = null, $description = null, $value = null, $rules = null )
    {
        $this->name = $name;
        $this->title = $title;
        $this->description = $description;
        $this->value = $value;
        $this->rules = $rules;
    }

    public function name()
    {
        return $this->name;
    }

    public function title()
    {
        return $this->title;
    }

    public function description()
    {
        return $this->description;
    }

    public function value()
    {
        return Session::hasOldInput($this->name()) ? Session::getOldInput($this->name()) : $this->value;
    }

    abstract public function render();

    public function before()
    {
        if (!empty($this->title)) {
            $return = "<label>" . $this->title();
            if (is_array($this->rules) && array_search("required", $this->rules) !== false) {
                $return.= " * ";
            }
            $return .= "</label>";

            return $return;
        }
    }

    public function after()
    {
        return '';
    }

}
