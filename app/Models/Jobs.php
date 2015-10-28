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
        $validated = $this->validate($data);
        if($validated['error'] == false){
             return $this->create($data);
        }else{
            return $validated;
        }
    }

    public function updateBeforeValidation($data, $id){
        $validated = $this->validate($data, $id);
        if($validated['error'] == false){
             return $this->update($data);
        }else{
            return $validated;
        }
    }

    private function validate( $data , $id = null){
        $langs = all_langs();
        $errors = [];

        if(key_exists('es', $data)){
                if($data['es']['title'] == ''){
                    $errors['error'][] = 'El campo titulo en español es obligatorio.';
                    return  $errors;
                }
        }

        return true;
    }

    public function allJobsActive()
    {
        return $this->where('active', '=', 1)->get();
    }

    public function searchJobs($search)
    {
        return $this->select('jobs.*')
            ->join(DB::raw('jobs_translations jt'), 'jt.jobs_id', '=', 'jobs.id')
            ->where('jobs.active', '=', 1)
            ->where('jt.title','LIKE' ,  '%' . $search . '%')
            ->get();
    }

}
