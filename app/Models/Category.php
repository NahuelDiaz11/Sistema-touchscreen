<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    //Validaciones

    public static function rules($id){
        //Actualizacion de categoria
        if($id<=0){
           return ['name'=>'required|min:3|max:50|unique:categories'];


        }else{
            return ['name'=>'required|min:3|max:50|unique:categories,name,{$id}']; //filtramos las categorias siempre cuando sea diferentes
        }

    }

    public static $messages = [
        'name.required'=>'Nombre requerido',
        'name.min'=>'El nombre debe tener al menos 3 caracteres',
        'name.min'=>'El nombre debe tener maximo 50 caracteres',
        'name.unique'=>'La categoria ya existe'
    ];

    //Relaciones
    public function products(){
        return $this->hasMany(Product::class);
    }

    function image(){
        return $this->morphOne(Image::class,'model')->withDefault(); //con el with si obtenemos null nos devuelve una instanca vacia de image
    }

    //mutators y accessors

    public function getImgAttribute(){
        $img = $this->image->file; //amalcenamos file en img temporalmente
        if($img !=null){
            if(file_exists('storage/categories' . $img))
            return 'storage/categories' . $img;
            else
            return 'storage/image-not-found.png'; //cuando no existe imagen
        }
        return 'storage/noimg.jpg'; //cuando no tiene imagen asociado en la bd
    }

}
