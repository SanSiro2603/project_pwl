@extends('layouts.customer')

@section('title', 'Form Booking')

@section('content')
<div class="container mt-5" style="max-width: 600px;">
    <h2 class="mb-4 text-primary fw-bold">Booking Studio: {{ $studio->name }}</h2>

    <!-- Tombol Kembali -->
    <a href="{{ route('customer.studios.index') }}" class="btn btn-outline-secondary mb-4">
        <i class="bi bi-arrow-left me-2"></i> Kembali ke Daftar Studio
    </a>

    <form action="{{ route('customer.bookings.store') }}" method="POST" class="shadow p-4 rounded bg-white">
        @csrf
        <input type="hidden" name="studio_id" value="{{ $studio->id }}">

        <div class="mb-3">
            <label for="booking_date" class="form-label fw-semibold">Tanggal Booking</label>
            <input type="date" name="booking_date" id="booking_date" 
                   class="form-control @error('booking_date') is-invalid @enderror" 
                   value="{{ old('booking_date') }}" required>
            @error('booking_date')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label fw-semibold">Jam Mulai</label>
            <input type="time" name="start_time" id="start_time" 
                   class="form-control @error('start_time') is-invalid @enderror" 
                   value="{{ old('start_time') }}" required>
            @error('start_time')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label fw-semibold">Jam Selesai</label>
            <input type="time" name="end_time" id="end_time" 
                   class="form-control @error('end_time') is-invalid @enderror" 
                   value="{{ old('end_time') }}" required>
            @error('end_time')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success w-100 fw-semibold">
            <i class="bi bi-check-circle me-2"></i> Lanjutkan Booking
        </button>
    </form>
</div>
@endsection
