<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::where('user_id', Auth::id())->count();
        $completedBookings = Booking::where('user_id', Auth::id())
                                  ->where('status', 'completed')
                                  ->count();
        $pendingBookings = Booking::where('user_id', Auth::id())
                                 ->where('status', 'pending')
                                 ->count();

        $recentBookings = Booking::with('studio')
                                ->where('user_id', Auth::id())
                                ->latest()
                                ->take(5)
                                ->get();

        return view('customer.dashboard', compact(
            'totalBookings', 'completedBookings', 
            'pendingBookings', 'recentBookings'
        ));
    }
}