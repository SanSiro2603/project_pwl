@extends('layouts.app')

@section('title', 'Edit Studio')

@section('content')
<div class="container">
    <h2>Edit Studio</h2>
    <hr>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.studios.update', $studio->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-3">
            <label for="name" class="form-label">Nama Studio</label>
            <input type="text" class="form-control" id="name" name="name" 
                value="{{ old('name', $studio->name) }}" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description', $studio->description) }}</textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Fasilitas</label>
            @php
                $oldFacilities = old('facilities', $studio->facilities ?? []);
            @endphp

            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="AC" id="facility1" name="facilities[]" 
                    {{ (is_array($oldFacilities) && in_array('AC', $oldFacilities)) ? 'checked' : '' }}>
                <label class="form-check-label" for="facility1">AC</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="WiFi" id="facility2" name="facilities[]" 
                    {{ (is_array($oldFacilities) && in_array('WiFi', $oldFacilities)) ? 'checked' : '' }}>
                <label class="form-check-label" for="facility2">WiFi</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Kursi" id="facility3" name="facilities[]" 
                    {{ (is_array($oldFacilities) && in_array('Kursi', $oldFacilities)) ? 'checked' : '' }}>
                <label class="form-check-label" for="facility3">Kursi</label>
            </div>
            <!-- Tambah fasilitas lain sesuai kebutuhan -->
        </div>
        
        <div class="mb-3">
            <label for="price_per_hour" class="form-label">Harga per Jam (Rp)</label>
            <input type="number" class="form-control" id="price_per_hour" name="price_per_hour" 
                min="0" step="1000" value="{{ old('price_per_hour', $studio->price_per_hour) }}" required>
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Foto Studio (opsional)</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*">
            @if ($studio->image)
                <p class="mt-2">Gambar saat ini:</p>
                <img src="{{ asset('storage/' . $studio->image) }}" alt="Studio Image" width="200">
            @endif
        </div>
        
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.studios.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
