<?php

namespace App\Http\Controllers;

use App\Services\PaymentBase;
use App\Services\PlaceToPayPayment;
use Illuminate\Http\Request;
use Inertia\Response;

class PaymentController extends Controller
{
    public function processPayment(Request $request, PlaceToPayPayment $paymentService):void
    {
        $paymentService->pay($request);
    }

    public function processResponse(PlaceToPayPayment $placeToPayPayment):Response
    {
        return $placeToPayPayment->getRequestInformation();
    }
}
