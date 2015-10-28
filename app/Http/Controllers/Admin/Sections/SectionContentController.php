<?php

namespace Potoroze\Http\Controllers\Admin\Sections;

use Potoroze\SectionContents\EloquentSectionContentRepository;
use Potoroze\Http\Controllers\Admin\BaseController;
use Potoroze\Services\FileServices;
use App,
    Input,
    Validator;
use Request;
use Session;

final class SectionContentController extends BaseController
{

    protected $repositoryName = EloquentSectionContentRepository::class;
    protected $resourceName = 'sectionContent';
    protected $pathImage = 'images/section/';

    public function show(EloquentSectionContentRepository $sectionContentRepository)
    {
        $brandsHead = [
            'id' => 'id',
            'section_name' => 'Seccion',
            'position' => 'Posicion',
            'title' => 'Titulo',
            'text' => 'Texto',
            'url' => 'Link', 
            'url_text' => 'Texto del Link', 
            'image' => 'Imagen',
            'status' => 'Estado'
        ];

        return view('admin.datatable', [
            'data' => $sectionContentRepository->filtered(Session::get('sections_filters', [])),
            'pageTitle' => 'Listado de Contenidos',
            'header' => $brandsHead,
            'extras' => ['admin.sections.partials.filters']
        ]);
    }
    
    public function addFilters()
    {
        Session::set('sections_filters', Input::get('filters'));

        return back();
    }

    public function delete(EloquentSectionContentRepository $sectionContentRepository,$id)
    {
        $sectionContent = $sectionContentRepository->find($id);
        if (!empty($slide)) {
            //FALTA BORRAR LA IMAGEN
            $sectionContent->delete();
        }
        $route = resource_home($this->resourceName);
        return redirect($route);
    }

    public function save()
    {
        $data = Input::all();
        unset($data['image_prev']);

        $rules = get_rules_from($this->resourceName);
        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return back()
                            ->withInput()
                            ->withErrors($validation->errors());
        }

        $data['image'] = FileServices::uploadFile('image', $this->pathImage);

        $repo = App::make($this->repositoryName);
        $repo->add($data);

        $route = resource_home($this->resourceName);

        return redirect($route);
    }

    public function update($id)
    {
        $data = Input::all();
        $uploadImage = true;

        if (!empty($data['image_prev']) && empty(Request::hasFile('image'))) {
            $uploadImage = false;
            $data['image'] = $data['image_prev'];
        }
        unset($data['image_prev']);

        $rules = get_rules_from($this->resourceName);
        $validation = Validator::make($data, $rules);

        if ($validation->fails()) {
            return back()
                            ->withInput()
                            ->withErrors($validation->errors());
        }

        if ($uploadImage) {
            $fileUpload = FileServices::uploadFile('image', $this->pathImage);
            $data['image'] = $fileUpload?$fileUpload:'';
        }

        $repo = App::make($this->repositoryName);
        $resource = $repo->find($id);
        $resource->update($data);

        $route = resource_home($this->resourceName);

        return redirect($route);
    }

}
