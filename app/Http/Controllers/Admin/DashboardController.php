<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Studio;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudios = Studio::count();
        $totalBookings = Booking::count();
        $totalCustomers = User::where('role', 'customer')->count();
        $monthlyRevenue = Booking::where('payment_status', 'paid')
                                ->whereMonth('created_at', Carbon::now()->month)
                                ->sum('total_price');

        $recentBookings = Booking::with(['user', 'studio'])
                                ->latest()
                                ->take(5)
                                ->get();

        return view('admin.dashboard', compact(
            'totalStudios', 'totalBookings', 
            'totalCustomers', 'monthlyRevenue', 'recentBookings'
        ));
    }
}
