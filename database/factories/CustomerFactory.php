<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name(),
            'phone'=>$this->faker->numerify('##########'),
            'street'=>$this->faker->streetName(),
            'number'=>$this->faker->buildingNumber(),
            'province'=>$this->faker->state(),
            'city'=>$this->faker->city(),
            'zipcode'=>$this->faker->postcode(),
            'country'=> Str::limit($this->faker->country(),49)
        ];
    }
}
