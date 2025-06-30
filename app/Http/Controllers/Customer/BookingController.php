<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Studio;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Str;

// Midtrans
use Midtrans\Snap;
use Midtrans\Config;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('studio')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('customer.bookings.index', compact('bookings'));
    }

    public function create($studioId)
    {
        $studio = Studio::findOrFail($studioId);
        $schedules = Schedule::where('studio_id', $studioId)
            ->where('is_available', true)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('customer.bookings.create', compact('studio', 'schedules'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'studio_id' => 'required|exists:studios,id',
            'booking_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);

        $studio = Studio::findOrFail($request->studio_id);

        $start = Carbon::parse($request->start_time);
        $end = Carbon::parse($request->end_time);
        $durationHours = max(1, $end->diffInHours($start));
        $totalPrice = $durationHours * $studio->price_per_hour;

        $booking = Booking::create([
            'user_id' => Auth::id(),
            'studio_id' => $request->studio_id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration_hours' => $durationHours,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'payment_status' => 'pending',
            'booking_code' => 'BK-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
        ]);

        return redirect()->route('customer.bookings.pay', $booking->id)
                         ->with('success', 'Booking berhasil dibuat. Silakan lanjutkan pembayaran.');
    }

    public function pay($id)
    {
        $booking = Booking::with('user')->findOrFail($id);

        if ($booking->status !== 'pending' || $booking->payment_status !== 'pending') {
            return redirect()->route('customer.bookings.index')->with('error', 'Booking sudah dibayar atau tidak valid.');
        }

        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$clientKey = env('MIDTRANS_CLIENT_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'BOOK-' . $booking->id, // Harus sama dengan callback
                'gross_amount' => (int) $booking->total_price,
            ],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return view('customer.bookings.pay', compact('booking', 'snapToken'));
    }
}
