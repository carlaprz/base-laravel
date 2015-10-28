<?php namespace App\Core\Form\Fields;

use Session;

abstract class AbstractField implements Field
{
    private $name;
    private $title;
    private $description;
    private $value;

    public function __construct($name, $title, $description, $value = null)
    {
        $this->name = $name;
        $this->title = $title;
        $this->description = $description;
        $this->value = $value;
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
        return Session::hasOldInput($this->name())
            ? Session::getOldInput($this->name())
            : $this->value;
    }

    abstract public function render();

    public function before()
    {
        return "
            <label>
                {$this->title()}
            </label>
        ";
    }

    public function after()
    {
        return '';
    }
}
