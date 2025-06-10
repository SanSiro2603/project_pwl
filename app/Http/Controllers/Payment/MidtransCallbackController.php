<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Mail\BookingSuccessMail;
use Illuminate\Support\Facades\Mail;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $validSignature = hash('sha512',
            $request->order_id .
            $request->status_code .
            $request->gross_amount .
            $serverKey
        );

        if ($request->signature_key !== $validSignature) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        if ($request->transaction_status === 'settlement') {
            $id = str_replace('BOOK-', '', $request->order_id);
            $booking = Booking::find($id);
            if ($booking && $booking->status !== 'confirmed') {
                $booking->update([
                    'status' => 'confirmed',
                    'payment_status' => 'paid',
                ]);

                // Kirim email sukses booking
                Mail::to($booking->user->email)->send(new BookingSuccessMail($booking));
            }
        }

        return response()->json(['message' => 'Notification processed']);
    }
}
