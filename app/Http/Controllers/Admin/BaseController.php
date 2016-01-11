<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Core\Form\FormGenerator;
use App,
    Input;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Services\FileServices;
use Validator;

abstract class BaseController extends Controller
{

    use DispatchesCommands,
        ValidatesRequests;

    protected $resourceName = '';
    protected $repositoryName = '';

    public function __construct()
    {
        
    }

    public function create( FormGenerator $formBuilder )
    {
        return view('admin.form.form', [
            'form' => $formBuilder->generate($this->resourceName)
        ]);
    }

    public function edit( FormGenerator $formBuilder, $id )
    {
        $repo = App::make($this->repositoryName);
        $data = $repo->find($id);
        return view('admin.form.form', [
            'form' => $formBuilder->generate(
                    $this->resourceName, $data->toArray()
            )
        ]);
    }

    public function save( Request $request )
    {
        $repo = App::make($this->repositoryName);
        $rules = get_rules_from($this->resourceName);

        $data = $this->prepareData(Input::all(), $request);

        $validations = $this->prepareValidate($data, $rules, null);

        if (!empty($validations) && is_object($validations)) {
            return back()->withInput()->withErrors($validations);
        }

        $data = $this->clearLang($data);
        $repo->add($data, $rules);

        $route = resource_home($this->resourceName);
        return redirect($route);
    }

    public function update( $id, Request $request )
    {
        $repo = App::make($this->repositoryName);

        $resource = $repo->find($id);

        $rules = get_rules_from($this->resourceName);
        $data = $this->prepareData(Input::all(), $request);

        $validations = $this->prepareValidate($data, $rules, $resource->id);
        if (!empty($validations) && is_object($validations)) {
            return back()->withInput()->withErrors($validations);
        }

        $data = $this->clearLang($data);
        
        //dd($data);
        $resource->update($data);

        $route = resource_home($this->resourceName);
        return redirect($route);
    }

    private function prepareValidate( $data, $rules, $id = null )
    {
        $validations = $this->validate($data, $rules, $id);

        $error = false;
        $errorMessages = new \Illuminate\Support\MessageBag;

        foreach ($validations as $validation) {
            if ($validation->fails() == true) {
                $error = true;
                $errorMessages->merge($validation->errors()->toArray());
            }
        }

        if ($error === true) {
            return ($errorMessages);
        } else {
            return false;
        }
    }

    public function validate( $data, $rules, $id = null )
    {
        $langs = langs_array();
        $errors = [];

        if (!empty($id)) {
           
            $parent = isset($data['parent'])?$data['parent']:'';
            
            foreach ($rules as $key => $rulesArray) {
                if (is_array($rulesArray)) {
                    foreach ($rulesArray as $subKey => $rule) {
                        if (is_array($rule)) {
                            foreach ($rule as $subsubKey => $value) {
                                $val = $value;
                                if (preg_match("/unique:id/i", $value)) {
                                    $val = str_replace("{unique:id}", $id, $val);
                                }
                                
                                if (preg_match("/unique:parent/i", $value)) {
                                    $val= str_replace("{unique:parent}", $parent, $val);
                                    
                                }
                                //echo 'value: '.$val.'<br/>';
                                $rules[$key][$subKey][$subsubKey] = $val;
                            }
                        } else {
                            $val = $rule;
                            if (preg_match("/unique:id/i", $rule)) {
                                $val = str_replace("{unique:id}", $id, $val);
                            }
                            if (preg_match("/unique:parent/i", $rule)) {
                               $val = str_replace("{unique:parent}", $parent, $val);
                            }
                            
                            $rules[$key]= $val;
                        }
                    }
                }
            }
        }
       
        
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (in_array($key, $langs)) {
                    $errors[] = Validator::make($value, $rules[$key]);
                    unset($data[$key]);
                    unset($rules[$key]);
                }
            }
        }
        
        $errors[] = Validator::make($data, $rules);
       
        return $errors;
    }

    private function prepareData( $data, $request )
    {
        if (isset($this->pathFile)) {
            $data = FileServices::uploadFilesRequest($request, $data, $this->pathFile, $this->filesDimensions);
        }

        //generate slugs
        $data = $this->generateSlugs($data);
        $data = $this->clearDescription($data);

        //generate parent 
        $data = $this->generateParent($data);

        $data = $this->removePrev($data);

        //$data = $this->clearLang($data);

        return $data;
    }

    private function clearDescription( $data )
    {
        foreach ($data as $index => $value) {
            if (is_array($value)) {
                foreach ($value as $key => $val) {
                    if ($val == '<p><br></p>') {
                        $data[$index][$key] = null;
                    }
                }
            } else {
                if ($value == '<p><br></p>') {
                    $data[$index] = null;
                }
            }
        }

        return $data;
    }

    private function clearLang( $data )
    {
        foreach ($data as $index => $value) {
            if (is_array($value)) {
                $clearLang = true;
                foreach ($value as $key => $val) {
                    if (!empty($val)) {
                        $clearLang = false;
                    }
                }
                if ($clearLang) {
                    unset($data[$index]);
                }
            }
        }

        return $data;
    }

    private function generateSlugs( $data )
    {
        $fields = get_slug_from($this->resourceName);
        if (!empty($fields)) {
            $langs = all_langs();
            foreach ($langs as $lang) {
                $slug = [];
                if (key_exists($lang->code, $data)) {
                    foreach ($fields as $field) {
                        if (isset($data[$lang->code][$field]) && !empty($data[$lang->code][$field])) {
                            $slug[$lang->code][] = slugify($data[$lang->code][$field]);
                        }
                    }
                }
                if (isset($slug[$lang->code]) && is_array($slug[$lang->code])) {
                    $data[$lang->code]['slug'] = implode('/', $slug[$lang->code]);
                }
            }
        }

        return $data;
    }

    private function removePrev( $data )
    {
        //remove all _prev
        $pattern = '/_prev$/';
        $keysPrevs = preg_array_key_exists($pattern, $data);


        if (!empty($keysPrevs)) {
            foreach ($keysPrevs as $key) {
                $realkey = str_replace('_prev', '', $key);
                $data[$realkey] = $data[$key];
                unset($data[$key]);
            }
        }
        //remove in arrays
        foreach ($data as $index => $value) {
            if (is_array($value)) {
                $keysPrevs = preg_array_key_exists($pattern, $value);
                if (!empty($keysPrevs)) {
                    foreach ($keysPrevs as $key) {
                        if (isset($data[$index][$key])) {
                            $realkey = str_replace('_prev', '', $key);
                            $data[$index][$realkey] = $data[$index][$key];
                            unset($data[$index][$key]);
                        }
                    }
                }
            }
        }
        return $data;
    }

    private function generateParent( $data )
    {
        if (isset($data['parent'])) {
            $langs = all_langs();
            foreach ($langs as $lang) {
                if (key_exists($lang->code, $data)) {
                    $data[$lang->code]['parent'] = $data['parent'];
                }
            }
        }

        return $data;
    }

    public function delete( $id )
    {
        $repo = App::make($this->repositoryName);
        $object = $repo->find($id);
        if (!empty($object)) {
            $object->delete();
        }
        $route = resource_home($this->resourceName);
        return redirect($route);
    }

}
