<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Product;

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
    public function definition(): array
    {
        return [
            'name'            => fake()->name(),
            'description'     => fake()->realText(2000),
            'price'           => fake()->numberBetween(1000, 300000),
            'quantity'        => fake()->numberBetween(1, 100),
            'product_photo'   =>'images/icecream.jpg',
        ];
    }
}
