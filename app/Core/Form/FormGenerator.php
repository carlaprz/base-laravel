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
use App\Core\Form\Fields\ImageCrop;
use App\Core\Form\Fields\Radio;
use App\Core\Form\Fields\RadioDisabled;
use App\Core\Form\Fields\Select;
use App\Core\Form\Fields\MultipleSelectProducts;
use App\Core\Form\Fields\File;
use App\Core\Form\Fields\URLImage;
use App\Core\Form\Fields\Hidden;
use App\Core\Form\Fields\Datetime;
use App\Core\Form\Fields\SelectDisabled;
use App\Core\Form\Fields\Link;
use App\Core\Form\Fields\Line;
use App\Core\Form\Fields\MultipleSelect;

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
        'imageCrop' => ImageCrop::class,
        'file' => File::class,
        'url_image' => URLImage::class,
        'radio' => Radio::class,
        'radioDisabled' => RadioDisabled::class,
        'select' => Select::class,
        'selectDisabled' => SelectDisabled::class,
        'hidden' => Hidden::class,
        'datetime' => Datetime::class,
        'link' => Link::class,
        'line' => Line::class,
        'multipleSelectProducts' => MultipleSelectProducts::class,
        'multipleSelect' => MultipleSelect::class
    ];

    public function generate( $config, array $defaultData = [] )
    {
        $data = (array) config($this->generateConfigFileName($config));
        $form = new Form($data['name'], $data['description'], $data['editor'], $data);

        $loopsInfo = [];
        //ADD GENERALS DATA
        foreach ($data['fields'] as $name => $fieldData) {
            $field = $this->generateField($name, $defaultData, $fieldData);

            if (strpos($name, "cant_") !== false) {
                $loopsInfo[$name] = $field->value();
            }

            $form->addField('generals', $field);
        }

        $loopGenerals = isset($data["loop"]) ? $data["loop"] : false;
        $form->addDataShow('generals', $loopGenerals);

        //ADD LENGUAGES DATA
        if (isset($data['lenguages'])) {
            foreach ($data['lenguages'] as $key => $value) {
                foreach ($value['fields'] as $name => $fieldData) {
                    $name = $key . '[' . $name . ']';
                    $field = $this->generateField($name, $defaultData, $fieldData);
                    $form->addField($key, $field);
                }
                $loopkey = isset($data[$key]["loop"]) ? $data[$key]["loop"] : false;
                $form->addDataShow($key, $loopkey);
            }
        }

        //ADD SPECIAL DATA
        if (isset($data['dataShow']) && is_array($data['dataShow'])) {
            foreach ($data['dataShow'] as $otherData) {
                $loopOtherData = isset($data[$otherData]["loop"]) ? isset($data[$otherData]["loop"]) : false;
                if ($loopOtherData) {
                    if (isset($loopsInfo['cant_' . $otherData]) && $loopsInfo['cant_' . $otherData] > 0) {
                        for ($i = 0; $i < $loopsInfo['cant_' . $otherData]; $i++) {
                            foreach ($data[$otherData]['fields'] as $name => $fieldData) {
                                $name = $otherData . '[' . $i . '][' . $name . ']';
                                $field = $this->generateField($name, $defaultData, $fieldData, $loopOtherData);
                                $form->addField($otherData, $field);
                            }
                        }
                    }
                } else {
                    foreach ($data[$otherData]['fields'] as $name => $fieldData) {
                        $name = $otherData . '[' . $name . ']';
                        $field = $this->generateField($name, $defaultData, $fieldData);
                        $form->addField($otherData, $field);
                    }
                }
                $form->addDataShow($otherData, $loopOtherData);
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
        if (count($dataAux) > 1 && count($dataAux) < 3) {
            $name = str_replace('[', '', $dataAux[0]);
            $secondname = str_replace(']', '', $dataAux[1]);
            return array_key_exists($name, $data) ? isset($data[$name][$secondname]) ? $data[$name][$secondname] : null : null;
        } else if (count($dataAux) > 2) {
            $name = str_replace('[', '', $dataAux[0]);
            $secondname = str_replace(']', '', $dataAux[1]);
            $thirdname = str_replace(']', '', $dataAux[2]);

            return isset($data[$name][$secondname][$thirdname]) ? $data[$name][$secondname][$thirdname] : null;
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

    private function generateField( $name, $defaultData, Array $fieldData, $loop = false )
    {
        $title = $fieldData['title'];
        $description = $fieldData['description'];
        $rules = isset($fieldData['rules']) ? $fieldData['rules'] : NULL;
        $value_dafault = isset($fieldData['value']) ? $fieldData['value'] : NULL;
        $value = empty($value_dafault) ? $this->getValue($defaultData, $name) : $value_dafault;
        $fieldClass = $this->fieldClass($fieldData['type']);
        
        return new $fieldClass($name, $title, $description, $value, $rules);
    }

}
