<?php

namespace Potoroze\Http\Controllers\Admin\Sections;


use Potoroze\Sliders\EloquentSliderRepository;
use Potoroze\Http\Controllers\Admin\BaseController;
use Potoroze\Services\FileServices;
use App,
    Input,
    Validator;
use Request;
use Session;

final class SlideController extends BaseController
{

    protected $repositoryName = EloquentSliderRepository::class;
    protected $resourceName = 'sliders';
    protected $pathImage = 'images/sliders/';

    public function show(EloquentSliderRepository $slide)
    {
        $brandsHead = [
            'id' => 'ID',
            'section_name' => 'Seccion',
            'alt_text' => 'Titulo',
            'url_image' => 'Url imagen',
            'image' => 'Imagen',
            'priority' => 'Prioridad ',
            'active' => 'Estado'
        ];

        return view('admin.datatable', [
            'data' => $slide->filtered(Session::get('sections_filters', [])),
            'pageTitle' => 'Listado de Slides',
            'header' => $brandsHead,
            'extras' => ['admin.sections.partials.filters']
        ]);
    }

    public function addFilters()
    {
        Session::set('sections_filters', Input::get('filters'));

        return back();
    }

    public function delete(EloquentSliderRepository $sliderRepository,$id)
    {
        $slide = $sliderRepository->find($id);
      
        if (!empty($slide)) {
            //FALTA BORRAR LA IMAGEN
            $slide->delete();
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
            $data['image'] = FileServices::uploadFile('image', $this->pathImage);
        }

        $repo = App::make($this->repositoryName);
        $resource = $repo->find($id);
        $resource->update($data);

        $route = resource_home($this->resourceName);

        return redirect($route);
    }

}
