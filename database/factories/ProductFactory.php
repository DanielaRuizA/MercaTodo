<?php

namespace Database\Factories;

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
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'description' => fake()->realText(150),
            'price' => fake()->numberBetween(1000, 300000),
            'quantity' => fake()->numberBetween(1, 100),
            'product_photo' => 'https://images.pexels.com/photos/54632/cat-animal-eyes-grey-54632.jpeg',
        ];
    }
}
