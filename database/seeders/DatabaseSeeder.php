<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeeder::class);

        User::factory()->create([
            'name' => 'admi1',
            'email' => 'i@admin.com',
            'password' => bcrypt('123456'),
        ])->assignRole('admin');

        User::factory(100)
            ->has(Order::factory()->count(2))
            ->afterCreating(function (User $user) {
                $user->orders->each(function (Order $order) {
                    $products = Product::factory(3)->make();
                    $order->products()->saveMany($products);
                    $products->each(function (Product $product) use ($order) {
                        $unitPrice = $product->price;
                        $quantity = fake()->numberBetween(1, 100);
                        $order->products()->updateExistingPivot($product->id, [
                            'quantity' => $quantity,
                            'unit_price' => $unitPrice,
                        ]);
                    });
                });
            })
            ->create();
    }
}
