@extends('layouts.app')

@section('title', 'Kelola Booking')

@section('content')
<div class="container">
    <h2><i class="fas fa-calendar-alt"></i> Kelola Booking</h2>
    <hr>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Customer</th>
                <th>Studio</th>
                <th>Tanggal</th>
                <th>Total</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $booking)
                <tr>
                    <td>{{ $booking->booking_code }}</td>
                    <td>{{ $booking->user->name }}</td>
                    <td>{{ $booking->studio->name }}</td>
                    <td>{{ $booking->booking_date->format('d/m/Y') }}</td>
                    <td>{{ $booking->formatted_total_price }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.bookings.updateStatus', $booking->id) }}">
    @csrf
    @method('PATCH')
    <div class="input-group">
        <select name="status" class="form-select form-select-sm">
            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
        </select>
        <button class="btn btn-sm btn-primary" type="submit">Ubah</button>
    </div>
</form>

                    </td>
                    <td>
                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="btn btn-sm btn-info">Detail</a>
                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus booking ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{ $bookings->links() }}
</div>
@endsection
