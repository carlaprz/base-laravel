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

    // OBLIGATORIO 
    protected $resourceName = "";
    protected $repositoryName = "";

    //Paginado PHP
    const TOTAL_ITEMS_PER_PAGE = "";

    //Relaciones multiples
    protected $repositoryRelated = [];
    protected $selfReferenceRelated = "";
    // IMAGENES 
    protected $pathFile = "";
    protected $filesDimensions = [
            //'image' => ['w' => 400, 'h' => 400]       
    ];

    /*     * ******************* VISTAS *********************************************** */

    public function create( FormGenerator $formBuilder )
    {
        return view('admin.form.form', [
            'form' => $formBuilder->generate($this->resourceName),
            'repository' => $this->resourceName
        ]);
    }

    public function edit( FormGenerator $formBuilder, $id )
    {
        $repo = App::make($this->repositoryName);
        $data = $repo->find($id);

        return view('admin.form.form', [
            'form' => $formBuilder->generate(
                    $this->resourceName, $data->toArray()
            ),
            'repository' => $this->resourceName
        ]);
    }

    public function crop( FormGenerator $formBuilder, $id )
    {
        $repo = App::make($this->repositoryName);
        $data = $repo->find($id);

        return view('admin.form.crop', [
            'form' => $formBuilder->generate(
                    $this->resourceName . '_crop', $data->toArray()
            ),
            'repository' => $this->resourceName,
            'id' => $id
        ]);
    }

    /*     * ********************** PROCESOS ******************************************** */

    public function save( Request $request )
    {
        $repo = App::make($this->repositoryName);
        $rules = get_rules_from($this->resourceName);

        $prepareData = $this->prepareData(Input::all(), $request);
        $validations = $this->prepareValidate($prepareData, $rules, null);

        if (!empty($validations) && is_object($validations)) {
            return back()->withInput()->withErrors($validations);
        }

        $dataClear = $this->clearLang($prepareData);
        $data = $this->getDataRelated($dataClear);

        $resource = $repo->add($data['data']);

        $this->dataRelated($data['related'], $resource);

        if (!empty($data["showCrop"]) && is_array($data["showCrop"])) {
            return redirect(route('admin.' . $this->resourceName . '.crop', $resource->id));
        }

        $route = resource_home($this->resourceName);
        return redirect($route);
    }

    public function update( $id, Request $request )
    {
        $repo = App::make($this->repositoryName);
        $resource = $repo->find($id);

        $rules = get_rules_from($this->resourceName);
        $prepareData = $this->prepareData(Input::all(), $request);

        $validations = $this->prepareValidate($prepareData, $rules, $resource->id);
        if (!empty($validations) && is_object($validations)) {
            return back()->withInput()->withErrors($validations);
        }

        $dataClear = $this->clearLang($prepareData);
        $data = $this->getDataRelated($dataClear);

        $resource->update($data['data']);

        $showCrop = $data['related']['showCrop'];
        unset($data['related']['showCrop']);
        //RELATED MANY TO MANY
        $this->dataRelated($data['related'], $resource);

        if (!empty($showCrop) && is_array($showCrop)) {
            return redirect(route('admin.' . $this->resourceName . '.crop', $resource->id));
        }

        $route = resource_home($this->resourceName);
        return redirect($route);
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

    public function cropSave()
    {
        $data = Input::all();
        unset($data["_token"]);
        foreach ($data as $key => $imagen) {
            $d = $this->filesDimensions;
            FileServices::cropImage($this->pathFile, $imagen, $d[$key]["w"]);
        }

        $route = resource_home($this->resourceName);
        return redirect($route);
    }

    public function orderSave()
    {
        $repo = App::make($this->repositoryName);
        $data = Input::all();
        $data = explode(',', $data['order']);

        $order = 1;
        foreach ($data as $item) {
            $resource = $repo->find($item);
            $dataAux = ['order' => $order];
            $resource->update($dataAux);
            $order++;
        }

        $route = resource_home($this->resourceName);
        return redirect($route);
    }

    /*     * ********************************************************************** */

    private function prepareData( $data, $request )
    {
        $dataWithImages = FileServices::uploadFilesRequest($request, $data, $this->pathFile, $this->filesDimensions);
        $dataAutoComplete = $this->generateAutocomplete($dataWithImages);
        $dataWithSlug = $this->generateSlugs($dataAutoComplete);
        $dataWithOutDescriptionEmpty = $this->clearDescription($dataWithSlug);
        $dataGenerateParent = $this->generateParent($dataWithOutDescriptionEmpty);
        $dataRemovePrev = $this->removePrev($dataGenerateParent);
        return $dataRemovePrev;
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

    private function validate( $data, $rules, $id = null )
    {
        $langs = langs_array();
        $errors = [];
        if (!empty($id)) {
            $parent = isset($data['parent']) ? $data['parent'] : '';
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
                                    $val = str_replace("{unique:parent}", $parent, $val);
                                }
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
                            $rules[$key] = $val;
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

    private function clearDescription( $data )
    {
        foreach ($data as $index => $value) {
            if (is_array($value)) {
                foreach ($value as $key => $val) {
                    if ($val === '<p><br></p>') {
                        $data[$index][$key] = null;
                    }
                }
            } else {
                if ($value === '<p><br></p>') {
                    $data[$index] = null;
                }
            }
        }

        return $data;
    }

    private function generateAutocomplete( $data )
    {
        $fields = get_autocomplete_from($this->resourceName);
        if (!empty($fields)) {
            $langs = all_langs();
            foreach ($langs as $lang) {
                foreach ($fields as $keyOrigin => $keyCopy) {
                    if (empty($data[$lang->code][$keyOrigin]) && !empty($data[$lang->code][$keyCopy])) {
                        $data[$lang->code][$keyOrigin] = $data[$lang->code][$keyCopy];
                    }
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
                            if (empty($data[$lang->code]['slug'])) {
                                $slug[$lang->code][] = slugify($data[$lang->code][$field]);
                            } else {
                                $slug[$lang->code][] = $data[$lang->code]['slug'];
                            }
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

    private function getDataRelated( $data )
    {
        $related = [];
        foreach ($data as $key => $value) {
            if (is_array($value) && !in_array($key, langs_array())) {
                $related[$key] = $value;
                unset($data[$key]);
            }
        }
        return ['data' => $data, 'related' => $related];
    }

    private function dataRelated( $data, $resource )
    {
        $repositories = $this->repositoryRelated;
        foreach ($data as $field => $values) {
            $repository = App::make($repositories[$field]);
            $this->deleteRelated($repository, $resource);
            $this->addRelated($field, $values, $repository, $resource);
        }
    }

    private function deleteRelated( $repository, $resource )
    {
        $objects = $repository->where($this->selfReferenceRelated, $resource->id)->get();
        foreach ($objects as $object) {
            if (is_object($object)) {
                $object->delete();
            }
        }
    }

    private function addRelated( $field, $values, $repository, $resource )
    {
        foreach ($values as $value) {
            $data = [$field => $value, $this->selfReferenceRelated => $resource->id];
            $repository->add($data);
        }
    }

}
