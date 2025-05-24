<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Studio;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        Booking::create([
            'user_id' => Auth::id(),
            'studio_id' => $request->studio_id,
            'booking_date' => $request->booking_date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'status' => 'pending',
        ]);

        return redirect()->route('customer.bookings.index')
            ->with('success', 'Booking berhasil dibuat.');
    }
}
