<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Mail\BookingSuccessMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        // Ambil raw body untuk validasi signature
        $rawBody = file_get_contents('php://input');
        $json = json_decode($rawBody);

        $serverKey = env('MIDTRANS_SERVER_KEY');
        $expectedSignature = hash('sha512',
            $json->order_id .
            $json->status_code .
            $json->gross_amount .
            $serverKey
        );

        if ($json->signature_key !== $expectedSignature) {
            Log::warning("Invalid signature for order {$json->order_id}");
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Ambil ID dari order_id seperti "BOOK-123"
        $id = str_replace('BOOK-', '', $json->order_id);
        $booking = Booking::find($id);

        if (!$booking) {
            Log::warning("Booking not found for order ID {$json->order_id}");
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Update status jika transaksi sukses
        if ($json->transaction_status === 'settlement') {
            $booking->update([
                'status' => 'confirmed',
                'payment_status' => 'paid',
            ]);

            // Kirim email jika user dan email ada
            if ($booking->user && $booking->user->email) {
                Mail::to($booking->user->email)->send(new BookingSuccessMail($booking));
            }

            Log::info("Booking #{$booking->id} confirmed and paid via Midtrans.");
        }

        // Bisa tambah status lain (deny, expire, etc) kalau perlu

        return response()->json(['message' => 'Notification processed']);
    }
}
