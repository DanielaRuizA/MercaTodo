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
            'product_photo'   => $this->faker->imageUrl,
            //'product_photo'   => "https://images.unsplash.com/photo-1555982105-d25af4182e4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=400&h=400&q=80",
            // 'product_photo'   => fake()->imageUrl(),
        ];
    }
}
