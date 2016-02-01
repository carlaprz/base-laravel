<?php

namespace App\Core\Form;

use App\Core\Form\Fields\Field;

final class Form
{

    private $fields = [];
    private $name;
    private $description;
    private $editor;
    private $data = [];
    private $dataShow = [];

    public function __construct( $name, $description, $editor, $data = [] )
    {
        $this->name = $name;
        $this->description = $description;
        $this->editor = $editor;
        $this->data = $data;
    }

    public function addField( $type, Field $field )
    {
        $this->fields[$type][] = $field;
    }

    public function name()
    {
        return $this->name;
    }

    public function description()
    {
        return $this->description;
    }

    public function fields( $type )
    {
        return isset($this->fields[$type]) ? $this->fields[$type] : null;
    }

    public function editor()
    {
        return $this->editor;
    }

    public function route( $to )
    {
        return route($this->data[$to]);
    }

    public function isForFiles()
    {
        return (array_key_exists('for_files', $this->data) &&
                $this->data['for_files']);
    }

    public function addDataShow( $show ,$loop =false )
    {
        $this->dataShow[] = [ 'title' => $show , 'loop' => $loop];
    }

    public function getDataShow()
    {
        return $this->dataShow;
    }

}
