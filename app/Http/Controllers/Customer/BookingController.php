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

    $start = \Carbon\Carbon::parse($request->start_time);
    $end = \Carbon\Carbon::parse($request->end_time);

    // Hitung durasi jam (jika kurang dari 1 jam, bisa dianggap 1 jam atau 0 tergantung logika)
    $durationHours = max(1, $end->diffInHours($start));

    $totalPrice = $durationHours * $studio->price_per_hour;

    Booking::create([
        'user_id' => Auth::id(),
        'studio_id' => $request->studio_id,
        'booking_date' => $request->booking_date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'duration_hours' => $durationHours,
        'total_price' => $totalPrice,
        'status' => 'pending',
        'booking_code' => 'BK-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
    ]);

    return redirect()->route('customer.bookings.index')
                     ->with('success', 'Booking berhasil dibuat.');
}

}
