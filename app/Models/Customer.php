<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    //define las columnas que se van a llenar de forma masiva en el componente
    protected $fillable = ['name', 'phone', 'street', 'number', 'city', 'province', 'zipcode', 'country', 'notes'];

    //relationship
    public function orders()
    {
        //clientes puede tener muchas ordenes
        return $this->hasMany(Order::class);
    }

    //se puede acceder a la funcion de manera directa sin tener que instansear la clase
    //le paso el id que se quiere actualizar
    public function rules($id)
    {
        if ($id <= 0) {
            return [
                'name' => 'required|min:3|string|unique:customers',
                'phone' => 'nullable|max:10',
                'stret' => 'nullable|max:100',
                'number' => 'nullable|max:20',
                'province' => 'nullable|max:60',
                'city' => 'nullable|max:65',
                'country' => 'nullable|max:70',
                'zipcode' => 'nullable|min:5',
                'note' => 'nullable|max:1000'
            ];
        } else {
            [
                'name' => "required|min:3|string|unique:customers, name,{$id}",
                'phone' => 'nullable|max:10',
                'stret' => 'nullable|max:100',
                'number' => 'nullable|max:20',
                'province' => 'nullable|max:60',
                'city' => 'nullable|max:65',
                'country' => 'nullable|max:50',
                'zipcode' => 'nullable|min:5',
                'note' => 'nullable|max:1000'
            ];
        }
    }

    public static $messages=[
        'name.required'=> 'Nombre requerido',
        'name.min'=> 'El nombre debe tener al menos 3 caracteres',
        'name.unique' => 'El nombre ya existe',
        'phone.max' => 'El telefono puede tener maximo 10 caracteres',
        'street.max'=> 'La calle puede tener maximo 100 caracteres',
        'number.max' => 'El numero puede tener maximo 10 caracteres',
        'province.max' =>'La provincia puede tener maximo 60 caracteres',
        'city.max' => 'La ciudad puede tener maximo 65 caracteres',
        'zipcode.min' => 'El zipcode debe tener minimo 5 caracteres',
        'country.max' => 'El pais puede tener maximo 50 caracteres',
        'notes.max' => 'La notas puede tener maximo 1000 caracteres',
    ];
}
