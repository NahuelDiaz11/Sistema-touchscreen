<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'price', 'price2', 'changes', 'stock', 'minstock', 'category_id'];
    //validaciones cuando se agregue o edite registros
    public static function rules($id)
    {
        if ($id <= 0) {
            return [
                'name' => 'required|min:3|max:100|string|unique:products',
                'code' => 'nullable|max:25',
                //no permite que el usuario cargue la opcion de elegir en categorias
                'category' => 'required|not_in:elegir',
                //para que el precio sea mayor a 0
                'price' => 'gt:0',
                'cost' => 'gt:0',
                'stock' => 'required',
                'minstock' => 'required',
            ];
        }
        else{
            return [
                //cuando se actualiza un producto se verifica que no haya otro con el mismo nombre
                'name' => "required|min:3|max:100|string|unique:products,name,{$id}",
                'code' => 'nullable|max:25',
                //no permite que el usuario cargue la opcion de elegir en categorias
                'category' => 'required|not_in:elegir',
                //para que el precio sea mayor a 0
                'price' => 'gt:0',
                'cost' => 'gt:0',
                'stock' => 'required',
                'minstock' => 'required'
            ];

        }
    }

    public static $messages = [
        'name.required' => 'Nombre del producto requerido',
        'name.min' => 'El nombre del producto debe tener al menos 3 caracteres',
        'name.max' => 'El nombre del producto debe tener maximo 100 caracteres',
        'name.unique'=> 'El nombre ya existe',
        'code.max' => 'El codigo debe tener maximo 20 caracteres',
        'category.required' => 'La categoria es requerida',
        'category.not_in' => 'Elige una categoria valida',
        'cost.gt' => 'El costo debe ser mayor a cero',
        'price.gt' => 'El precio debe ser mayor a cero',
        'stock.required' => 'Ingresa el stock',
        'minstock.required' => 'Ingresa el stock maximo'

    ];

    //relaciones

    public function sales()
    {
        return $this->hasMany(OrderDetail::class);
    }

    //el producto tiene una relacion con categorias y este producto pertenece a una categoria
    public function category()
    {
       return $this->belongsTo(Category::class);
    }

    //obtenemos las imagenes que tienen los productos asociados
    public function images()
    {
        return $this->morphMany(Image::class, 'model');
    }

    //obtenemos la ultima imagen que se le relacione al producto
    public function latestImage()
    {
        return $this->morphOne(Image::class, 'model')->latestOfMany();
    }

    //accesores

    public function getImgAttribute()
    {
        //si el count dice que si tiene imagenes relacionadas retorna la ultima imagen asociada al producto
        if(count($this->images)){
            if(file_exists('storage/products/'. $this->images->last()->file))
            return "storage/products/" . $this->images->last()->file;
            else
            return 'storage/image_not_found.png';
        } else{
            return 'storage/noimg.jpg';
        }
    }
}
