<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    //define las columnas que se van a llenar de forma masiva en el componente
    protected $fillable=['name','phone','street','number','city','province','zipcode','country','notes'];

    //relationship
    public function orders()
    {
        //clientes puede tener muchas ordenes
        return $this->hasMany(Order::class);

    }

}
