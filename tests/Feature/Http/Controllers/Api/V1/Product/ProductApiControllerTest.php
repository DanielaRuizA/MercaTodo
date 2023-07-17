<?php

namespace Tests\Feature\Http\Controllers\Api\V1\Product;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Fluent\AssertableJson;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProductApiControllerTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    public function testCantCallIndexProductsIfIsNotUnauthenticated(): void
    {
        /** @var Product $product */
        Product::factory(10)->create();

        $this->getJson(route('api.products.index'))
            ->assertUnauthorized();
    }

    public function testUserAuthenticatedCanCallIndexProducts(): void
    {
        /** @var Product $product */
        $this->user = User::factory()->create();

        Sanctum::actingAs($this->user);

        Product::factory(10)->create();

        $this->getJson(route('api.products.index'))
            ->assertOk()
            ->assertJson(function (AssertableJson $json) {
                $json->count('data', 10)->has('data.0', function (AssertableJson $data) {
                    $data->has('id')
                        ->has('name')
                        ->has('description')
                        ->has('status')
                        ->has('price')
                        ->has('quantity')
                        ->has('product_photo')
                        ->has('created_at')
                        ->has('updated_at');
                })->etc();
            });
    }

    public function testCantStoreProductsIfIsNotUnauthenticated(): void
    {
        /** @var Product $product */
        $product = Product::factory()->make();

        $this->postJson(route('api.products.store'), [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'quantity' => $product->quantity,
            'product_photo' => $product->product_photo,
        ])->assertUnauthorized()
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'Unauthenticated.');
            });

        $this->assertDatabaseMissing('products', [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'quantity' => $product->quantity,
            'product_photo' => $product->product_photo,
        ]);
    }

    public function testUserAuthenticatedCanStoreProducts(): void
    {
        /** @var Product $product */
        $this->user = User::factory()->create();

        Sanctum::actingAs($this->user);

        $product = Product::factory()->make();

        $this->postJson(route('api.products.store'), [
            'name' => $product->name,
            'description' => $product->description,
            'status' => 'Active',
            'price' => $product->price,
            'quantity' => $product->quantity,
            'product_photo' => $product->product_photo,
        ])->assertCreated()
            ->assertJson(function (AssertableJson $json) use ($product) {
                $json->where('message', 'the product was created successfully')
                    ->has('data', function (AssertableJson $data) use ($product) {
                        $data->has('id')
                            ->where('name', $product->name)
                            ->where('description', $product->description)
                            ->where('status', 'Active')
                            ->where('price', $product->price)
                            ->where('quantity', $product->quantity)
                            ->where('product_photo', $product->product_photo)
                            ->has('created_at')
                            ->has('updated_at');
                    });
            });

        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'description' => $product->description,
            'status' => 'Active',
            'price' => $product->price,
            'quantity' => $product->quantity,
            'product_photo' => $product->product_photo,
        ]);
    }

    public function testCanShowProductIfIsNotUnauthenticated(): void
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $this->getJson(route('api.products.show', $product->id))
            ->assertUnauthorized();
    }

    public function testUserAuthenticatedCanShowProduct(): void
    {
        /** @var Product $product */
        $this->user = User::factory()->create();

        Sanctum::actingAs($this->user);

        $product = Product::factory()->create();

        $this->getJson(route('api.products.show', $product->id))
            ->assertOk()
            ->assertJson(function (AssertableJson $json) use ($product) {
                $json->has('data', function (AssertableJson $data) use ($product) {
                    $data->has('id')
                        ->where('name', $product->name)
                        ->where('description', $product->description)
                        ->has('status')
                        ->where('price', $product->price)
                        ->where('quantity', $product->quantity)
                        ->where('product_photo', $product->product_photo)
                        ->has('created_at')
                        ->has('updated_at');
                });
            });
    }

    public function testCantUpdateIfIsNotUnauthenticated(): void
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $this->putJson(route('api.products.update', $product->id), [
            'name' => 'Name',
            'description' => 'description',
            'price' => 2000,
            'quantity' => 10,
            'product_photo' => 'images/icecream.jpg',
        ])->assertUnauthorized()
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'Unauthenticated.')->etc();
            });

        $this->assertDatabaseMissing('products', [
            'name' => 'Name',
            'description' => 'description',
            'price' => 2000,
            'quantity' => 10,
            'product_photo' => 'images/icecream.jpg',
        ]);
    }

    public function testUserAuthenticatedCanUpdate(): void
    {
        /** @var Product $product */
        $this->user = User::factory()->create();

        Sanctum::actingAs($this->user);

        $product = Product::factory()->create();

        $this->putJson(route('api.products.update', $product->id), [
            'name' => 'Name',
            'description' => 'description',
            'status' => 'Active',
            'price' => 2000,
            'quantity' => 10,
            'product_photo' => 'images/icecream.jpg',
        ])->assertOk()
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'the product was updated successfully')
                    ->has('data', function ($json) {
                        $json->where('id', 1)
                            ->where('name', 'Name')
                            ->where('description', 'description')
                            ->where('status', 'Active')
                            ->where('price', 2000)
                            ->where('quantity', 10)
                            ->etc();
                    });
            });

        $this->assertDatabaseHas('products', [
            'name' => 'Name',
            'description' => 'description',
            'status' => 'Active',
            'price' => 2000,
            'quantity' => 10,
            'product_photo' => 'images/icecream.jpg',
        ]);
    }

    public function testCantDestroyIfIsNotUnauthenticated(): void
    {
        /** @var Product $product */
        $product = Product::factory()->create();

        $this->deleteJson(route('api.products.destroy', $product->id))
            ->assertUnauthorized()
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'Unauthenticated.')->etc();
            });

        $this->assertDatabaseHas('products', [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'quantity' => $product->quantity,
            'product_photo' => $product->product_photo,
        ]);
    }

    public function testUserAuthenticatedCanDestroy(): void
    {
        /** @var Product $product */
        $this->user = User::factory()->create();

        Sanctum::actingAs($this->user);

        $product = Product::factory()->create();

        $this->deleteJson(route('api.products.destroy', $product->id))
            ->assertOk()
            ->assertJson(function (AssertableJson $json) {
                $json->where('message', 'the product was deleted successfully');
            });

        $this->assertDatabaseMissing('products', [
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'quantity' => $product->quantity,
            'product_photo' => $product->product_photo,
        ]);
    }
}
