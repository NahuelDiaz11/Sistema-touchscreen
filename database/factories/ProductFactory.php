<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $cost=$this->faker->randomfloat(2,0,1000); //definimos el valor al costo al que compramos productos
        $price1 = $cost *1.40; //precio de venta incrementado al 40%
        $price2 = $price1 -($price1*0.05); //precio de descuento del 5%
        $stock = $this->faker->numberBetween(0,500);


        return [
            'category_id' => Category::all()->random()->id,
            'name'=>$this->faker->word(6),
            'code'=>$this->faker->unique()->ean13(),
            'changes'=>'',
            'cost'=>$cost,
            'price'=>$price1,
            'price2'=>$price2,
            'stock'=>$stock,
            'minstock'=>$this->faker->randomElement([5,10,15,20,25]) //num random entre 5 y 25



        ];
    }
}
