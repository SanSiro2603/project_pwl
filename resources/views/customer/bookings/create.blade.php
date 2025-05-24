@extends('layouts.customer')

@section('title', 'Form Booking')

@section('content')
<div class="container">
    <h2>Booking Studio: {{ $studio->name }}</h2>

    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf
        <input type="hidden" name="studio_id" value="{{ $studio->id }}">

        <div class="mb-3">
            <label for="booking_date" class="form-label">Tanggal Booking</label>
            <input type="date" name="booking_date" id="booking_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="start_time" class="form-label">Jam Mulai</label>
            <input type="time" name="start_time" id="start_time" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_time" class="form-label">Jam Selesai</label>
            <input type="time" name="end_time" id="end_time" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-success">Lanjutkan Booking</button>
    </form>
</div>
@endsection
