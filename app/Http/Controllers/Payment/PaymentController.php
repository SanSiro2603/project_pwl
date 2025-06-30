<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function pay(Booking $booking)
    {
        // Pastikan user hanya bisa membayar booking miliknya
        if ($booking->user_id !== Auth::id()) {
            abort(403, 'Unauthorized booking access.');
        }

        // Pastikan total_price tidak null dan valid
        if (!$booking->total_price || $booking->total_price <= 0) {
            abort(400, 'Invalid booking price.');
        }

        // Siapkan parameter Snap
        $params = [
            'transaction_details' => [
                // order_id harus unik setiap kali request
                'order_id' => 'BOOK-' . $booking->id . '-' . time(),
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
        } catch (\Exception $e) {
            Log::error('Midtrans Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memproses pembayaran. Coba lagi nanti.');
        }

        return view('customer.bookings.pay', compact('booking', 'snapToken'));
    }
}
