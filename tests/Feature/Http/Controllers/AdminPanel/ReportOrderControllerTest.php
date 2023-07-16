<?php

namespace Tests\Feature\Http\Controllers\AdminPanel;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Maatwebsite\Excel\Facades\Excel;

class ReportOrderControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    // public function setUp(): void
    // {
    // parent::setUp();

    // Storage::fake('public');

    // $roleAdmin = Role::create(['name' => 'admin']);

    // Permission::create(['name' => 'admin.products.edit'])->assignRole($roleAdmin);

    // $admin = User::factory()->create()->assignRole('admin');

    // $users = User::factory()->create();

    // $order = Order::factory()->create;

    // $order = Order::factory()->create([
        //     'code' => '123abc',
        //     'user_id' => $this->user_client->id,
        //     'purchase_date' => '2023-07-01 12:00:00',
        //     'purchase_total' => '500000',
    // ]);


    // $response = $this->actingAs($admin);
    // }

    public function testAdminCanSearchWithFilters(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.create.report'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $user = User::factory()->create();

        $order = Order::factory()->create([
            'order_id' => 12345,
            'user_id' => 1,
            'created_at' => '2023-07-14 15:30:00',
            'amount' => '2000000',
        ]);

        $response = $this->actingAs($admin)
            ->get('/orders/report?date1=&date2=&'.'orderStatus=PENDING&minAmount=1000000&maxAmount=2000000');

        // 127.0.0.1:8000/orders/report?date1=&date2=&orderStatus=PENDING&minAmount=1000000&maxAmount=2000000
        $response->assertStatus(200)->assertInertia(
            fn (Assert $page) => $page
                -> component('AdminPanel/Reports/Orders/Table')
                -> has('filters')
                -> has(
                    'orders',
                    fn (Assert $page) => $page
                    -> where('orders_id', $order->orders_id)
                    -> where('created_at', $order->created_at)
                    -> where('amount', intval($order->amount))
                    -> where('status', $order->status)
                    -> where('url', $order->url)
                    -> where('updated_at', $order->updated_at)
                    -> where('name', $user->name)
                    -> where('email', $user->email)
                    -> etc()
                )
                -> has('success')
        );
    }
}
