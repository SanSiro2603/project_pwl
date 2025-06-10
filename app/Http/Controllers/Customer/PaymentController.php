<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Booking;

class PaymentController extends Controller
{
    public function pay(Request $request, Booking $booking)
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $booking->id . '-' . time(),
                'gross_amount' => $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
            ],
            'callbacks' => [
                'finish' => route('customer.bookings.index')
            ]
        ];

        
        $snapToken = Snap::getSnapToken($params);

        return view('customer.payment.snap', compact('snapToken'));
    }
}

