<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['total','shipping','items','duscount','cash','type','status','user_id','customer_id','notes','delivery_data'];

     //relaciones para obtener las relaciones de cada una de las ordenes
     public function details(){
        return $this->hasMany(OrderDetail::class);
    }
    //una venta esta relacionada con un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function customer()
    {
        return $this->belongsTo(Customer::class)->withDefault(); // guarda relaciones de venta con el cliente en general
    }


}
