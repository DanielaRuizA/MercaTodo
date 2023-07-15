<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=> User::factory()->create(),
            'order_id'=> $this->faker->lexify,
            'url' => $this->faker->url(),
            'amount'=> $this->faker->randomNumber(7, false),
            'currency' => $this->faker->randomElement(['COP']),
            'status' => $this->faker->randomElement(['PENDING', 'COMPLETED', 'CANCELED']),
        ];
    }
}
