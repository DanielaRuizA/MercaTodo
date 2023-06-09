<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PlaceToPayPayment;
use App\Services\PaymentBase;

class PaymentController extends Controller
{
    public function processPayment(Request $request, PlaceToPayPayment $paymentService)
    {
        $paymentService->pay($request);
    }

    private function sendEmail(PaymentBase $base): void
    {
        $base->sendNotification();
    }

    public function processResponse(PlaceToPayPayment $placeToPayPayment)
    {
        return $placeToPayPayment->getRequestInformation();
    }
}
