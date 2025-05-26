@extends('layouts.customer')

@section('title', 'Daftar Booking')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-primary fw-bold">Daftar Booking Saya</h1>

    <!-- Tombol Aksi Cepat -->
    <div class="d-flex justify-content-center flex-wrap gap-3 mb-4">
        <a href="{{ route('customer.dashboard') }}" 
           class="btn quick-action border border-primary text-primary" 
           data-bg="primary">
            <i class="bi bi-speedometer2 me-2"></i> Dashboard
        </a>
        <a href="{{ route('customer.studios.index') }}" 
           class="btn quick-action border border-success text-success" 
           data-bg="success">
            <i class="bi bi-camera-video-fill me-2"></i> Lihat Studio
        </a>
        <a href="{{ route('customer.bookings.index') }}" 
           class="btn quick-action border border-warning text-warning active" 
           data-bg="warning">
            <i class="bi bi-calendar-check-fill me-2"></i> Riwayat Booking
        </a>
    </div>

    @if ($bookings->isEmpty())
        <div class="alert alert-info rounded shadow-sm">
            Anda belum memiliki booking.
        </div>
    @else
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-bordered table-hover align-middle mb-0" style="min-width: 900px;">
                <thead class="table-light text-center align-middle">
                    <tr>
                        <th>Studio</th>
                        <th>Tanggal</th>
                        <th>Jam Mulai</th>
                        <th>Jam Selesai</th>
                        <th>Durasi (jam)</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                    <tr class="text-center">
                        <td class="text-start">{{ $booking->studio->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</td>
                        <td>{{ $booking->duration_hours }}</td>
                        <td class="text-success fw-semibold">
                            Rp {{ number_format($booking->total_price, 0, ',', '.') }}
                        </td>
                        <td>
                            @if ($booking->status === 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($booking->status === 'confirmed')
                                <span class="badge bg-success">Confirmed</span>
                            @elseif ($booking->status === 'cancelled')
                                <span class="badge bg-danger">Cancelled</span>
                            @else
                                <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Custom CSS for quick action buttons -->
<style>
.quick-action {
    transition: background-color 0.3s, color 0.3s;
    border-radius: 0.5rem;
    padding: 0.625rem 1.5rem;
    font-weight: 600;
}
.quick-action:hover {
    color: #fff !important;
}
.quick-action[data-bg="primary"]:hover {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
}
.quick-action[data-bg="success"]:hover {
    background-color: #198754 !important;
    border-color: #198754 !important;
}
.quick-action[data-bg="warning"]:hover {
    background-color: #ffc107 !important;
    border-color: #ffc107 !important;
}
.quick-action.active {
    background-color: var(--bs-warning);
    color: #212529 !important;
    font-weight: 700;
}
</style>
@endsection
