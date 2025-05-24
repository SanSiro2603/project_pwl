@extends('layouts.customer')

@section('title', 'Daftar Booking')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Daftar Booking Saya</h1>

    @if ($bookings->isEmpty())
        <div class="alert alert-info">
            Anda belum memiliki booking.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-light">
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
                    <tr>
                        <td>{{ $booking->studio->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->start_time)->format('H:i') }}</td>
                        <td>{{ \Carbon\Carbon::parse($booking->end_time)->format('H:i') }}</td>
                        <td>{{ $booking->duration_hours }}</td>
                        <td>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</td>
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
@endsection
