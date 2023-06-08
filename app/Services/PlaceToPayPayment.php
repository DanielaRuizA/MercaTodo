<?php

namespace App\Services;

use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Contracts\PaymentInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\RedirectResponse;
use App\Domain\Order\OrderCreateAction;
use App\Domain\Order\OrderUpdateAction;
use Illuminate\Database\Eloquent\Model;
use App\Domain\Order\OrderGetLastAction;

class PlaceToPayPayment implements PaymentInterface
{
    public function pay(Request $request)
    {
        Log::info('[PAY]: Pago con PlaceToPay');

        $order = OrderCreateAction::execute($request->all());

        $result = Http::post(
            config('placetopay.url').config('placetopay.route.api'),
            $this->createSession($order, $request->ip(), $request->userAgent())
        );

        if ($result->ok()) {
            $order->order_id = $result->json()['requestId'];
            $order->url = $result->json()['processUrl'];

            OrderUpdateAction::execute($order);
            // return redirect()->to($order->url)->send();
            return Inertia::location($order->url)->send();
        }

        throw new \Exception($result->body());
    }

    public function sendNotification()
    {
        Log::info('[PAY]: Enviamos la notificacion PlaceToPay');
    }

    private function createSession(Model $order, string $ipAddress, string $userAgent): array
    {
        return [
            'auth' => $this->getAuth(),
            'buyer' => [
                'name' => auth()->user()->name,
                'email' => auth()->user()->email,
            ],
            "payment" => [
                "reference" =>  $order->id,
                "description" =>'prueba',
                "amount" => [
                    "currency" => "COP",
                    "total" => $order->amount,
                ]
            ],
            "expiration" => Carbon::now()->addHour(),
            "returnUrl" => route('payments.processResponse'),
            "ipAddress" => $ipAddress,
            "userAgent" => $userAgent,
        ];
    }

    private function getAuth(): array
    {
        $nonce = Str::random();
        $seed = date('c');

        return [
            'login' => config('placetopay.login'),
            'tranKey' => base64_encode(
                hash(
                    'sha256',
                    $nonce.$seed.config('placetopay.tranKey'),
                    true
                )
            ),
            'nonce' => base64_encode($nonce),
            'seed' => $seed,
        ];
    }

    public function getRequestInformation(): View
    {
        $order = OrderGetLastAction::execute();

        $result = Http::post(config('placetopay.url') . "/api/session/$order->order_id", [
            'auth' => $this->getAuth()
        ]);

        if ($result->ok()) {
            $status = $result->json()['status']['status'];
            if ($status == 'APPROVED') {
                $order->completed();
            } elseif ($status == 'REJECTED') {
                $order->canceled();
            }

            return view('payments.success', [
                'status' => $order->status
            ]);
        }

        throw  new \Exception($result->body());
    }
}
