@extends('layouts.customer')

@section('title', 'Daftar Studio')

@section('content')
    <h1>Daftar Studio</h1>

    <div class="row">
        @foreach ($studios as $studio)
            <div class="col-md-4 mb-4 d-flex align-items-stretch">
                <div class="card w-100">
                    @if($studio->image)
                        <img src="{{ asset('storage/' . $studio->image) }}" class="card-img-top" alt="{{ $studio->name }}">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $studio->name }}</h5>
                        <p class="card-text flex-grow-1" style="overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 4; -webkit-box-orient: vertical;">
                            {{ $studio->description }}
                        </p>
                        <a href="{{ route('customer.studios.show', $studio->id) }}" class="btn btn-primary mt-auto">Lihat Detail</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
