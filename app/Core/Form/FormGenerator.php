<?php

namespace App\Core\Form;

use App\Core\Form\Fields\Email;
use App\Core\Form\Fields\EmailDisabled;
use App\Core\Form\Fields\ImageFile;
use App\Core\Form\Fields\Numeric;
use App\Core\Form\Fields\NumericDisabled;
use App\Core\Form\Fields\Text;
use App\Core\Form\Fields\TextDisabled;
use App\Core\Form\Fields\Textarea;
use App\Core\Form\Fields\Image;
use App\Core\Form\Fields\Radio;
use App\Core\Form\Fields\Select;
use App\Core\Form\Fields\File;
use App\Core\Form\Fields\URLImage;
use App\Core\Form\Fields\Hidden;
use App\Core\Form\Fields\Datetime;

final class FormGenerator
{

    private $configFileName = 'form';
    private $fieldsMap = [
        'numeric' => Numeric::class,
        'numericDisabled' => NumericDisabled::class,
        'text' => Text::class,
        'textDisabled' => TextDisabled::class,
        'textarea' => Textarea::class,
        'email' => Email::class,
        'emailDisabled' => EmailDisabled::class,
        'image' => Image::class,
        'image_file' => ImageFile::class,
        'file' => File::class,
        'url_image' => URLImage::class,
        'radio' => Radio::class,
        'select' => Select::class,
        'hidden' => Hidden::class,
        'datetime' => Datetime::class
    ];

    public function generate( $config, array $defaultData = [] )
    {
        $data = (array) config($this->generateConfigFileName($config));
        $form = new Form($data['name'], $data['description'], $data['editor'], $data);


        foreach ($data['fields'] as $name => $fieldData) {
            $field = $this->generateField($name, $defaultData, $fieldData);
            $form->addField('generals', $field);
        }

        if (isset($data['lenguages'])) {
            foreach ($data['lenguages'] as $key => $value) {
                foreach ($value['fields'] as $name => $fieldData) {
                    $name = $key . '[' . $name . ']';
                    $field = $this->generateField($name, $defaultData, $fieldData);
                    $form->addField($key, $field);
                }
            }
        }
        
        return $form;
    }

    private function generateConfigFileName( $config )
    {
        return $this->configFileName . '.' . $config;
    }

    private function getValue( array $data, $name )
    {

        $dataAux = explode('[', $name);

        if (count($dataAux) > 1) {

            $name = str_replace('[', '', $dataAux[0]);
            $secondname = str_replace(']', '', $dataAux[1]);
            return array_key_exists($name, $data) ? isset($data[$name][$secondname]) ? $data[$name][$secondname] : null : null;
        }

        return array_key_exists($name, $data) ? $data[$name] : null;
    }

    private function fieldClass( $type )
    {
        if (!array_key_exists($type, $this->fieldsMap)) {
            throw new FieldNotSupportedException($type);
        }

        return $this->fieldsMap[$type];
    }

    private function generateField( $name, $defaultData, Array $fieldData )
    {
        $title = $fieldData['title'];
        $description = $fieldData['description'];
        $rules = isset($fieldData['rules'])?$fieldData['rules']: NULL;  
        $value_dafault = isset($fieldData['value']) ? $fieldData['value'] : NULL;
        $value = empty($value_dafault) ? $this->getValue($defaultData, $name) :$value_dafault ;
        
        $fieldClass = $this->fieldClass($fieldData['type']);

        return new $fieldClass($name, $title, $description, $value, $rules);
    }

}
