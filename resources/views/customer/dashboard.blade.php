@extends('layouts.customer')

@section('title', 'Dashboard Customer')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Selamat Datang, {{ Auth::user()->name }}</h2>

    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Booking</h5>
                    <p class="card-text fs-4">{{ $totalBookings }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Selesai</h5>
                    <p class="card-text fs-4">{{ $completedBookings }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning mb-3">
                <div class="card-body">
                    <h5 class="card-title">Menunggu</h5>
                    <p class="card-text fs-4">{{ $pendingBookings }}</p>
                </div>
            </div>
        </div>
    </div>

    <h4>Booking Terbaru</h4>
    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3">
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
                            <span class="badge bg-{{ $booking->status === 'completed' ? 'success' : ($booking->status === 'pending' ? 'warning' : 'secondary') }}">
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
