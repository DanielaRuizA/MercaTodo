<?php

namespace Tests\Feature\Http\Controllers\AdminPanel;

use App\Models\Order;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class ReportOrderControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function testAdminCanSearchWithFilters(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.create.report'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        User::factory()->create();

        Order::factory()->create([
            'order_id' => 12345,
            'user_id' => 1,
            'created_at' => '2023-07-14 15:30:00',
            'amount' => '2000000',
        ]);

        $response = $this->actingAs($admin)
            ->get('/orders/report?date1=&date2=&'.'orderStatus=PENDING&minAmount=1000000&maxAmount=2000000');

        $response->assertStatus(200)->assertInertia(
            fn (Assert $page) => $page
                ->component('AdminPanel/Reports/Orders/Table')
                ->has('filters')
                ->has('orders')
                ->has('success')
        );
    }

    public function testAdminCanSearchWithFiltersDates(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.create.report'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        User::factory()->create();

        $order = Order::factory()->create([]);

        $response = $this->actingAs($admin)
            ->get('/orders/report?date1='.$order->created_at.'&date2='.$order->created_at);

        $response->assertStatus(200)->assertInertia(
            fn (Assert $page) => $page
                ->component('AdminPanel/Reports/Orders/Table')
                ->has('filters')
                ->has('orders')
                ->has('success')
        );
    }

    public function testAdminCanSearchWithFiltersDate1(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.create.report'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        User::factory()->create();

        $order = Order::factory()->create([]);

        $response = $this->actingAs($admin)
            ->get('/orders/report?date1='.$order->created_at);

        $response->assertStatus(200)->assertInertia(
            fn (Assert $page) => $page
                ->component('AdminPanel/Reports/Orders/Table')
                ->has('filters')
                ->has('orders')
                ->has('success')
        );
    }

    public function testAdminCanSearchWithFiltersDate2(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.create.report'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        User::factory()->create();

        $order = Order::factory()->create([]);

        $response = $this->actingAs($admin)
            ->get('/orders/report?date1=&date2='.$order->created_at);

        $response->assertStatus(200)->assertInertia(
            fn (Assert $page) => $page
                ->component('AdminPanel/Reports/Orders/Table')
                ->has('filters')
                ->has('orders')
                ->has('success')
        );
    }

    public function testAdminCanSearchWithFiltersAmount(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.create.report'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        User::factory()->create();

        $order = Order::factory()->create([]);

        $response = $this->actingAs($admin)
            ->get('orders/report?minAmount='.$order->amount.'&maxAmount='.$order->amount);

        $response->assertStatus(200)->assertInertia(
            fn (Assert $page) => $page
                ->component('AdminPanel/Reports/Orders/Table')
                ->has('filters')
                ->has('orders')
                ->has('success')
        );
    }

    public function testAdminCanSearchWithFiltersMinAmount(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.create.report'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        User::factory()->create();

        $order = Order::factory()->create([]);

        $response = $this->actingAs($admin)
            ->get('orders/report?minAmount='.$order->amount);

        $response->assertStatus(200)->assertInertia(
            fn (Assert $page) => $page
                ->component('AdminPanel/Reports/Orders/Table')
                ->has('filters')
                ->has('orders')
                ->has('success')
        );
    }

    public function testAdminCanSearchWithFiltersMaxAmount(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.create.report'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        User::factory()->create();

        $order = Order::factory()->create([]);

        $response = $this->actingAs($admin)
            ->get('orders/report?minAmount=&maxAmount='.$order->amount);

        $response->assertStatus(200)->assertInertia(
            fn (Assert $page) => $page
                ->component('AdminPanel/Reports/Orders/Table')
                ->has('filters')
                ->has('orders')
                ->has('success')
        );
    }

    public function testCanQueueGenerateReportOfOrders(): void
    {
        $roleAdmin = Role::create(['name' => 'admin']);

        Permission::create(['name' => 'admin.create.report'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        User::factory()->create();

        Order::factory()->create([
            'order_id' => 12345,
            'user_id' => 1,
            'created_at' => '2023-07-14 15:30:00',
            'amount' => '2000000',
        ]);

        Storage::fake('public');

        Excel::fake();

        $time = strval(time());

        $response = $this->actingAs($admin)
            ->post(route('orders.report.export'), [
                'time' => $time,
            ]);

        Excel::assertQueued('reports/orders/orders_'.$time.'.xlsx');

        $response->assertRedirect(route('orders.report.table'))
            ->assertSessionHasAll(['success' => 'The Report Of Orders Was Generated Successfully.']);
    }
}
