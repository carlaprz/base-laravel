<?php

namespace App\Models;

use DB;
use App;
use App\Interfaces\ModelInterface;
use Illuminate\Database\Eloquent\Model;

final class Jobs extends Model
{

    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['title', 'description'];
    protected $fillable = ['active', 'title', 'description'];
    protected $appends = ["es", "en", "fr"];

    public function getEsAttribute()
    {
        App::setLocale('es');
        return ['title' => $this->title, 'description' => $this->description];
    }

    public function getEnAttribute()
    {
        App::setLocale('en');
        return ['title' => $this->title, 'description' => $this->description];
    }

    public function getFrAttribute()
    {
        App::setLocale('fr');
        return ['title' => $this->title, 'description' => $this->description];
    }

    public function add( $data )
    {

    }

    public function addBeforeValidation( $data, $rules )
    {
        $validated = $this->validate($data, false, $rules);
        if ($validated['error'] == false) {
            return $this->create($data);
        } else {
            return $validated;
        }
    }

    public function updateBeforeValidation( $data, $id ,$rules)
    {
        $validated = $this->validate($data, $id, $rules);
        if ($validated['error'] == false) {
            return $this->update($data);
        } else {
            return $validated;
        }
    }

    private function validate( $data, $id = null, $rules )
    {
        $langs = all_langs();
        $errors = [];

        foreach ($rules as $key => $value) {

            if (is_array($value)) {
                foreach ($value as $field => $rule) {
                    if ($rule == 'required') {
                        if (empty($data[$key][$field])) {
                            $text = $field;
                            if ($field == 'title') {
                                $text = 'nombre';
                            }
                            $errors['error'][] = 'El campo ' . $text . ' en el idioma "' . strtoupper($key) . '" es obligatorio.';
                        }
                    }
                }
            } else {
                if ($value == 'required') {
                    if (isset($data[$key]) && empty($data[$key])) {
                        $text = $key;
                        if ($key == 'category_id') {
                            $text = 'categoria';
                        }

                        $errors['error'][] = 'El campo ' . $text . ' es obligatorio.';
                    }
                }
            }
        }

        if (!empty($errors)) {
            return $errors;
        }

        return true;
    }

    public function allJobsActive()
    {
        return $this->where('active', '=', 1)->get();
    }

    public function searchJobs( $search )
    {
        return $this->select('jobs.*')
                        ->join(DB::raw('jobs_translations jt'), 'jt.jobs_id', '=', 'jobs.id')
                        ->where('jobs.active', '=', 1)
                        ->where('jt.title', 'LIKE', '%' . $search . '%')
                        ->groupBy('jobs.id')
                        ->get();
    }

}
