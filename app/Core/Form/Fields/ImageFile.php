<?php namespace App\Core\Form\Fields;

class ImageFile extends AbstractField
{
    public function render()
    {
        $data = " <input type='file' name='{$this->name()}'/> "; 
        $image=pathinfo($this->value(),PATHINFO_BASENAME);
        $explodeImage = explode('.', $image);
        if(count($explodeImage)>1){
            $data.="<br>
                    <input type='hidden' id='{$this->name()}_prev' name='{$this->name()}_prev' value='".pathinfo($this->value(),PATHINFO_BASENAME)."' />
                    <div id='{$this->name()}'>
                        <img  src='{$this->value()}' style='max-width: 300px;'>";
                     
            $data.='<a style="margin-left: 10px;" data-id="'.$this->name().'" class="deleteImage btn btn-small btn-danger" title="Eliminar Imagen" >
                        <i class="glyphicon glyphicon-trash"> </i>
                    </a> Eliminar Imagen 
                    </div>' ; 
        }else{
            $data.=" <input type='hidden' name='{$this->name()}_prev' value='' />";
        } 
            
        return $data;
    }
}
