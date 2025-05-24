@extends('layouts.customer')

@section('title', $studio->name)

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-6">
            @if ($studio->image)
                <img src="{{ asset('storage/' . $studio->image) }}" class="img-fluid rounded" alt="{{ $studio->name }}">
            @else
                <img src="https://via.placeholder.com/600x400?text=No+Image" class="img-fluid rounded" alt="No Image">
            @endif
        </div>
        <div class="col-md-6">
            <h2>{{ $studio->name }}</h2>
            <p class="text-muted">Lokasi: {{ $studio->location ?? '-' }}</p>
            <p>{{ $studio->description }}</p>
            <p><strong>Harga Sewa:</strong> Rp {{ number_format($studio->price_per_hour, 0, ',', '.') }} / jam</p>

            <a href="{{ route('customer.bookings.create', $studio->id) }}" class="btn btn-success mt-3">Booking Sekarang</a>
        </div>
    </div>
</div>
@endsection
