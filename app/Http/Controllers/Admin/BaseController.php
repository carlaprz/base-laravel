<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Core\Form\FormGenerator;
use App,
    Input,
    Validator,
    Session,
    Redirect;
use Illuminate\Http\Request;
use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Services\FileServices;

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

    public function save( Request $request )
    {
        $data = Input::all();
        $data = $this->clearData($data);

        if (isset($this->pathFile)) {
            //upload files
            $data = FileServices::uploadFilesRequest($request, $data, $this->pathFile);
        }

        if (!empty($data['parent'])) {
            $langs = all_langs();

            foreach ($langs as $lang) {
                if (key_exists($lang->code, $data)) {
                    $data[$lang->code]['parent'] = $data['parent'];
                }
            }
        }

        //generate slugs
        $data = $this->generateSlugs($data);

        $rules = get_rules_from($this->resourceName);
        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation->errors());
        }

        $repo = App::make($this->repositoryName);
        $rs = $repo->add($data);
        if (!is_object($rs) && isset($rs['error'])) {
            return back()->withInput()->withErrors($rs['error']);
        }

        $route = resource_home($this->resourceName);

        return redirect($route);
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

    public function update( $id, Request $request )
    {

        $data = Input::all();
        $data = $this->clearData($data);

        if (isset($this->pathFile)) {
            //upload files
            $data = FileServices::uploadFilesRequest($request, $data, $this->pathFile);
        }

        //generate slugs
        $data = $this->generateSlugs($data);

        if (!empty($data['parent'])) {
            $langs = all_langs();
            foreach ($langs as $lang) {
                if (key_exists($lang->code, $data)) {
                    $data[$lang->code]['parent'] = $data['parent'];
                }
            }
        }

        $rules = get_rules_from($this->resourceName);
        $validation = Validator::make($data, $rules);
        if ($validation->fails()) {
            return back()->withInput()->withErrors($validation->errors());
        }

        $repo = App::make($this->repositoryName);
        $resource = $repo->find($id);

        $rs = $resource->updateBeforeValidation($data, $resource->id);
        if (!is_object($rs) && isset($rs['error'])) {
            return back()->withInput()->withErrors($rs['error']);
        }
        $route = resource_home($this->resourceName);
        return redirect($route);
    }

    private function guardUserIsLogged()
    {
        
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

    private function generateSlugs( $data )
    {

        $langs = all_langs();

        foreach ($langs as $lang) {
            if (key_exists($lang->code, $data)) {

                if (!empty($data[$lang->code]['name'])) {
                    $data[$lang->code]['slug'] = slugify($data[$lang->code]['name']);
                }

                if (!empty($data[$lang->code]['title'])) {
                    $data[$lang->code]['slug'] = slugify($data[$lang->code]['title']);
                }
            }
        }
        return $data;
    }

    private function clearData( $data )
    {
        foreach (all_langs() as $lang) {
            if (key_exists($lang->code, $data)) {
                $clearLang = true;
                foreach ($data[$lang->code] as $key => $value) {
                    if (empty($data[$lang->code][$key])) {
                        unset($data[$lang->code][$key]);
                    } else {
                        $clearLang = false;
                    }
                }
                if ($clearLang) {
                    unset($data[$lang->code]);
                }
            }
        }
        return $data;
    }

}
