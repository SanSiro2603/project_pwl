@extends('layouts.customer')

@section('title', 'Dashboard Customer')

@section('content')
<div class="container">
    <div class="text-center my-5">
        <h1 class="fw-bold mb-3">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
        <p class="lead text-muted">Terima kasih telah menggunakan layanan <strong>Booking Studio</strong>. Kamu dapat mulai memesan studio, melihat riwayat booking, atau mengecek status pemesananmu di sini.</p>

        <!-- Ilustrasi / Icon Besar -->
        <div class="my-4">
            <i class="bi bi-camera-reels display-1 text-primary"></i>
        </div>

        <!-- Tombol Aksi Cepat -->
<div class="d-flex justify-content-center flex-wrap gap-3 mt-4">
    <a href="{{ route('customer.dashboard') }}" class="btn quick-action border border-primary text-primary" data-bg="primary">
        <i class="bi bi-speedometer2 me-2"></i> Dashboard
    </a>
    <a href="{{ route('customer.studios.index') }}" class="btn quick-action border border-success text-success" data-bg="success">
        <i class="bi bi-camera-video-fill me-2"></i> Lihat Studio
    </a>
    <a href="{{ route('customer.bookings.index') }}" class="btn quick-action border border-warning text-warning" data-bg="warning">
        <i class="bi bi-calendar-check-fill me-2"></i> Riwayat Booking
    </a>
</div>


    <!-- Section Statistik -->
    <div class="row mt-5">
        <div class="col-md-4">
            <div class="card text-white bg-primary shadow-sm mb-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Total Booking</h5>
                        <p class="card-text fs-4">{{ $totalBookings }}</p>
                    </div>
                    <i class="bi bi-journal-bookmark-fill fs-1"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success shadow-sm mb-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Selesai</h5>
                        <p class="card-text fs-4">{{ $completedBookings }}</p>
                    </div>
                    <i class="bi bi-check-circle-fill fs-1"></i>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning shadow-sm mb-3">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Menunggu</h5>
                        <p class="card-text fs-4">{{ $pendingBookings }}</p>
                    </div>
                    <i class="bi bi-hourglass-split fs-1"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Terbaru -->
    <h4 class="mt-5">Booking Terbaru</h4>
    <div class="table-responsive mt-3">
        <table class="table table-bordered table-hover shadow-sm bg-white rounded">
            <thead class="table-dark">
                <tr>
                    <th>Studio</th>
                    <th>Tanggal Booking</th>
                    <th>Waktu</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentBookings as $booking)
                    <tr>
                        <td>{{ $booking->studio->name }}</td>
                        <td>{{ $booking->booking_date->format('d M Y') }}</td>
                        <td>{{ $booking->start_time }} - {{ $booking->end_time }}</td>
                        <td>
                            <span class="badge 
                                @if ($booking->status === 'completed') bg-success
                                @elseif ($booking->status === 'pending') bg-warning text-dark
                                @else bg-secondary @endif">
                                {{ ucfirst($booking->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Belum ada booking.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
