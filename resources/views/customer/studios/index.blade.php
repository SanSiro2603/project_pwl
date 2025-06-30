@extends('layouts.customer')

@section('title', 'Daftar Studio')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 fw-bold"> Studio Tersedia</h1>

    <!-- Tombol Aksi Cepat -->
    <div class="d-flex justify-content-center flex-wrap gap-3 mb-5">
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

    <!-- Daftar Studio -->
    <div class="row">
        @forelse ($studios as $studio)
            <div class="col-md-4 mb-4 d-flex align-items-stretch">
                <div class="card studio-card shadow-sm rounded-4 w-100 overflow-hidden position-relative">
                    @if($studio->image)
                        <div class="img-wrapper">
                            <img src="{{ asset('storage/' . $studio->image) }}" class="card-img-top studio-img" alt="{{ $studio->name }}">
                            <div class="img-overlay"></div>
                        </div>
                    @else
                        <div class="img-wrapper">
                            <img src="https://via.placeholder.com/400x250?text=No+Image" class="card-img-top studio-img" alt="No Image">
                            <div class="img-overlay"></div>
                        </div>
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title text-primary fw-bold studio-title">{{ $studio->name }}</h5>
                        <p class="card-text text-muted flex-grow-1" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">
                            {{ $studio->description }}
                        </p>
                        <a href="{{ route('customer.studios.show', $studio->id) }}" class="btn btn-outline-primary mt-auto rounded-pill">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted">Tidak ada studio yang tersedia saat ini.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Quick Action Button */
    .quick-action {
        background-color: #fff;
        transition: all 0.3s ease;
        font-size: 1.05rem;
        padding: 0.75rem 1.5rem;
        border-radius: 10px;
    }

    .quick-action:hover {
        transform: translateY(-3px);
        color: #fff !important;
    }

    .quick-action[data-bg="primary"]:hover {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }

    .quick-action[data-bg="success"]:hover {
        background-color: #198754;
        border-color: #198754;
    }

    .quick-action[data-bg="warning"]:hover {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #000 !important;
    }

    /* Studio Card */
    .studio-card {
        transition: all 0.3s ease-in-out;
        background-color: #fff;
    }

    .studio-card:hover {
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        transform: translateY(-5px);
    }

    .studio-img {
        height: 200px;
        object-fit: cover;
        transition: transform 0.3s ease-in-out;
        border-bottom: 1px solid #eee;
    }

    .img-wrapper {
        position: relative;
        overflow: hidden;
    }

    .img-wrapper:hover .studio-img {
        transform: scale(1.05);
    }

    .img-overlay {
        position: absolute;
        top: 0; left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(180deg, rgba(0,0,0,0.15) 0%, rgba(0,0,0,0.3) 100%);
        opacity: 0;
        transition: opacity 0.3s ease-in-out;
    }

    .img-wrapper:hover .img-overlay {
        opacity: 1;
    }

    .studio-title {
        transition: color 0.3s ease-in-out;
    }

    .studio-card:hover .studio-title {
        color: #0d6efd;
    }
</style>
@endsection
