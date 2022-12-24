<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
     //relaciones para obtener las relaciones de cada una de las ordenes
     public function details(){
        return $this->hasMany(OrderDetail::class);
    }
}
