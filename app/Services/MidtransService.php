<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use Midtrans\Notification;

class MidtransCallbackController extends Controller
{
    public function receive(Request $request)
    {
        $notification = new Notification();

        $orderId = explode('-', $notification->order_id)[1];
        $transactionStatus = $notification->transaction_status;

        $booking = Booking::find($orderId);

        if ($transactionStatus == 'settlement') {
            $booking->status = 'confirmed';
        } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'expire') {
            $booking->status = 'cancelled';
        }

        $booking->save();

        return response()->json(['message' => 'Callback processed']);
    }
}
