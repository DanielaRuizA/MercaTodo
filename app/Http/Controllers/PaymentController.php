<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentFactoryInterface;
use App\Services\PaymentBase;
use App\Services\PlaceToPayPayment;
use Illuminate\Http\Request;

// use Inertia\Inertia;

class PaymentController extends Controller
{
    // public function Index()
    // {
    //     return Inertia::render('Checkout/Index.vue');
    // }

    public function processPayment(Request $request, PaymentFactoryInterface $paymentFactory)
    {
        $processor = $paymentFactory->initializePayment($request->get('payment_type'));
        return $processor->pay($request);
        /*$this->sendEmail($processor);
        return view('payments.success', [
            'processor' => $request->get('payment_type'),
            'status' => 'COMPLETED'
        ]);*/
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
