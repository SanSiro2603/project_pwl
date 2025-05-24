<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'studio']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan status pembayaran
        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('date_from')) {
            $query->whereDate('booking_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('booking_date', '<=', $request->date_to);
        }

        // Search berdasarkan nama customer atau kode booking
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('booking_code', 'like', "%{$search}%")
                  ->orWhereHas('user', function($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        $bookings = $query->latest()->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'studio']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function confirm(Booking $booking)
    {
        if ($booking->status !== 'pending') {
            return redirect()->back()->with('error', 'Booking ini tidak dapat dikonfirmasi.');
        }

        $booking->update([
            'status' => 'confirmed'
        ]);

        return redirect()->back()->with('success', 'Booking berhasil dikonfirmasi.');
    }

    public function cancel(Request $request, Booking $booking)
    {
        if (in_array($booking->status, ['cancelled', 'completed'])) {
            return redirect()->back()->with('error', 'Booking ini tidak dapat dibatalkan.');
        }

        $booking->update([
            'status' => 'cancelled',
            'notes' => $request->reason
        ]);

        return redirect()->back()->with('success', 'Booking berhasil dibatalkan.');
    }

    public function verifyPayment(Booking $booking)
    {
        if ($booking->payment_status !== 'pending') {
            return redirect()->back()->with('error', 'Status pembayaran tidak valid.');
        }

        $booking->update([
            'payment_status' => 'paid'
        ]);

        // Auto confirm booking jika pembayaran sudah diverifikasi
        if ($booking->status === 'pending') {
            $booking->update(['status' => 'confirmed']);
        }

        return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    public function rejectPayment(Request $request, Booking $booking)
    {
        if ($booking->payment_status !== 'pending') {
            return redirect()->back()->with('error', 'Status pembayaran tidak valid.');
        }

        $booking->update([
            'payment_status' => 'unpaid',
            'payment_proof' => null,
            'notes' => $request->reason
        ]);

        return redirect()->back()->with('success', 'Pembayaran ditolak. Customer dapat mengupload ulang bukti pembayaran.');
    }

    public function reports(Request $request)
    {
        $startDate = $request->get('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        // Total booking dalam periode
        $totalBookings = Booking::whereBetween('booking_date', [$startDate, $endDate])->count();

        // Total revenue dalam periode
        $totalRevenue = Booking::whereBetween('booking_date', [$startDate, $endDate])
                              ->where('payment_status', 'paid')
                              ->sum('total_price');

        // Booking per status
        $bookingByStatus = Booking::whereBetween('booking_date', [$startDate, $endDate])
                                 ->selectRaw('status, COUNT(*) as count')
                                 ->groupBy('status')
                                 ->pluck('count', 'status')
                                 ->toArray();

        // Studio terpopuler
        $popularStudios = Booking::with('studio')
                                ->whereBetween('booking_date', [$startDate, $endDate])
                                ->selectRaw('studio_id, COUNT(*) as booking_count, SUM(total_price) as total_revenue')
                                ->groupBy('studio_id')
                                ->orderByDesc('booking_count')
                                ->take(5)
                                ->get();

        // Revenue per bulan (untuk chart)
        $monthlyRevenue = Booking::selectRaw('MONTH(booking_date) as month, YEAR(booking_date) as year, SUM(total_price) as revenue')
                                ->where('payment_status', 'paid')
                                ->whereYear('booking_date', Carbon::parse($startDate)->year)
                                ->groupBy('year', 'month')
                                ->orderBy('year')
                                ->orderBy('month')
                                ->get();

        return view('admin.reports', compact(
            'startDate', 'endDate', 'totalBookings', 'totalRevenue',
            'bookingByStatus', 'popularStudios', 'monthlyRevenue'
        ));
    }

    public function complete(Booking $booking)
    {
        if ($booking->status !== 'confirmed') {
            return redirect()->back()->with('error', 'Booking harus dikonfirmasi terlebih dahulu.');
        }

        $booking->update([
            'status' => 'completed'
        ]);

        return redirect()->back()->with('success', 'Booking berhasil diselesaikan.');
    }
    
}