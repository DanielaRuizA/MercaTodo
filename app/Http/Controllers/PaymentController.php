<?php

namespace App\Http\Controllers;

use App\Services\PaymentBase;
use App\Services\PlaceToPayPayment;
use Illuminate\Http\Request;

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
