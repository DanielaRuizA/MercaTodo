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

        // User::factory(50)->create();

        // $product = Product::factory(100)->create();

        // Order::factory(50)->create()->each(function($orders) use($product)){

        // }


        // User::factory(100)
        //     ->has(Order::factory(2))
        //     ->has(Product::factory(3))
        //     ->create();

        
        User::factory(100)
            ->has(Order::factory()->count(2))
            ->afterCreating(function (User $user) {
                $user->orders->each(function (Order $order) {
                    $order->products()->saveMany(Product::factory(3)->make());
                });
            })
            ->create();
    }
}
