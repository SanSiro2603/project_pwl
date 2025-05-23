@extends('layouts.app')

@section('title', 'Detail Booking')

@section('content')
<div class="container">
    <h2><i class="fas fa-info-circle"></i> Detail Booking</h2>
    <hr>

    <div class="card mb-3">
        <div class="card-header bg-primary text-white">
            Informasi Booking
        </div>
        <div class="card-body">
            <p><strong>Kode Booking:</strong> {{ $booking->booking_code }}</p>
            <p><strong>Status:</strong> 
                <span class="badge bg-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'cancelled' ? 'danger' : 'secondary') }}">
                    {{ ucfirst($booking->status) }}
                </span>
            </p>
            <p><strong>Tanggal Booking:</strong> {{ $booking->booking_date->format('d/m/Y') }}</p>
            <p><strong>Durasi:</strong> {{ $booking->duration }} jam</p>
            <p><strong>Total Harga:</strong> {{ $booking->formatted_total_price }}</p>
        </div>
    </div>

    <div class="card mb-3">
        <div class="card-header bg-success text-white">
            Informasi Customer
        </div>
        <div class="card-body">
            <p><strong>Nama:</strong> {{ $booking->user->name }}</p>
            <p><strong>Email:</strong> {{ $booking->user->email }}</p>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-info text-white">
            Informasi Studio
        </div>
        <div class="card-body">
            <p><strong>Nama Studio:</strong> {{ $booking->studio->name }}</p>
            <p><strong>Harga per Jam:</strong> {{ number_format($booking->studio->price_per_hour, 0, ',', '.') }}</p>
            <p><strong>Fasilitas:</strong></p>
            <ul>
                @foreach($booking->studio->facilities as $facility)
                    <li>{{ $facility }}</li>
                @endforeach
            </ul>
            @if($booking->studio->image)
                <img src="{{ asset('storage/' . $booking->studio->image) }}" alt="{{ $booking->studio->name }}" width="200" class="img-thumbnail mt-2">
            @endif
        </div>
    </div>

    <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary mt-3">
        <i class="fas fa-arrow-left"></i> Kembali ke Daftar Booking
    </a>
</div>
@endsection
