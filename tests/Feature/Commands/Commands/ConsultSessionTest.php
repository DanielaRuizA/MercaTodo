<?php

namespace Tests\Feature\Commands\Commands;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;

class ConsultSessionTest extends TestCase
{
    use RefreshDatabase;

    private Order $order;
    private User $user;
    private array $mockResponse;


    public function setUp(): void
    {
        parent::setUp();

        Storage::fake('public');

        $roleAdmin = Role::create(['name' => 'admin']);

        $roleUser = Role::create(['name' => 'user']);

        Permission::create(['name' => 'admin.command.session'])->assignRole($roleAdmin);

        $admin = User::factory()->create()->assignRole('admin');

        $this->user = User::factory()->create()->assignRole('user');

        $this->actingAs($admin);

        $this->order = Order::factory()->create([
            'user_id' => $this->user->getKey(),
            'url' => 'https://checkout-co.placetopay.dev/spa/session/0000/0000',
            'order_id' => 0000,
            'status' => 'PENDING',
        ]);

        $this->mockResponse = [
            "requestId" => 0000,
            "status" => [
                "status" => "APPROVED",
                "reason" => "00",
                "message" => "La Transacción ha sido aprobada exitosamente",
                "date" => "2023-07-05T14:50:01-05:00"
            ],
            'payment' => [
                0 => [
                    'reference' => $this->order->order_id,
                    'description' => 'Transacción a Mercatodo',
                    'amount' => [
                        'currency' => 'COP',
                            'total' => $this->order->amount,
                        ]
                    ]
                ]
            ];
    }

    public function testExecuteCommandSchedule(): void
    {
        Http::fake([config('placetopay.url').'/*' => Http::response($this->mockResponse)]);

        $this->artisan('schedule:run')->assertExitCode(0);
    }

    public function testExecuteCommandConsultSessionChangeStatusCompleted(): void
    {
        Http::fake([config('placetopay.url').'/*' => Http::response($this->mockResponse)]);

        $this->artisan('app:consult-session')->assertExitCode(0);

        $this->assertEquals($this->order->status, 'PENDING');

        $this->order = $this->order->fresh();

        $this->assertEquals($this->order->status, 'COMPLETED');

        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id,
            'status' => 'COMPLETED',
        ]);
    }

    public function testExecuteCommandConsultSessionChangeStatusCanceled(): void
    {
        $mockResponsePaymentCanceled = [
            "requestId" => 0000,
            "status" => [
                "status" => "REJECTED",
                "reason" => "CD",
                "message" => "La Transacción se encuentra cancelada",
                "date" => "2023-07-05T14:50:01-05:00"
            ],
            "payment" => [
                0 => [
                    "status" => [
                        "status" => "REJECTED",
                        "message" => "La Transacción fue cancelada ",
                    ]
                ]
            ]
        ];

        Http::fake([config('placetopay.url').'/*' => Http::response($mockResponsePaymentCanceled)]);

        $this->artisan('app:consult-session')->assertExitCode(0);

        $this->assertEquals($this->order->status, 'PENDING');

        $this->order = $this->order->fresh();

        $this->assertEquals($this->order->status, 'CANCELED');

        $this->assertDatabaseHas('orders', [
            'id' => $this->order->id,
            'status' => 'CANCELED',
        ]);
    }
}
