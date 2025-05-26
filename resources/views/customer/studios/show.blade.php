@extends('layouts.customer')

@section('title', $studio->name)

@section('content')
<div class="container py-4">

    <a href="{{ route('customer.studios.index') }}" class="btn btn-outline-secondary mb-4 rounded-pill shadow-sm">
        <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Daftar Studio
    </a>

    <div class="row align-items-center g-4">
        <div class="col-md-6">
            @if ($studio->image)
                <img 
                    src="{{ asset('storage/' . $studio->image) }}" 
                    class="img-fluid rounded shadow-lg" 
                    alt="{{ $studio->name }}" 
                    style="object-fit: cover; max-height: 400px; width: 100%; transition: transform 0.3s ease;"
                    onmouseover="this.style.transform='scale(1.05)';"
                    onmouseout="this.style.transform='scale(1)';"
                >
            @else
                <img 
                    src="https://via.placeholder.com/600x400?text=No+Image" 
                    class="img-fluid rounded shadow-sm" 
                    alt="No Image"
                >
            @endif
        </div>

        <div class="col-md-6">
            <h2 class="fw-bold mb-3 text-primary">{{ $studio->name }}</h2>
            
            <p class="mb-4" style="line-height: 1.6;">{{ $studio->description }}</p>

            <p class="fs-5 mb-4">
                <strong>Harga Sewa:</strong> 
                <span class="text-success fs-4">Rp {{ number_format($studio->price_per_hour, 0, ',', '.') }} / jam</span>
            </p>

            <a href="{{ route('customer.bookings.create', $studio->id) }}" 
               class="btn btn-success btn-lg px-4 shadow-sm"
               style="transition: background-color 0.3s ease;">
                <i class="bi bi-calendar-check-fill me-2"></i> Booking Sekarang
            </a>
        </div>
    </div>

</div>
@endsection
