@extends('layouts.app')

@section('title', 'Tambah Studio Baru')

@section('content')
<div class="container">
    <h2>Tambah Studio Baru</h2>
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

    <form action="{{ route('admin.studios.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="name" class="form-label">Nama Studio</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Deskripsi</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
        </div>
        
        <div class="mb-3">
            <label class="form-label">Fasilitas</label>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="AC" id="facility1" name="facilities[]" {{ (is_array(old('facilities')) && in_array('AC', old('facilities'))) ? 'checked' : '' }}>
                <label class="form-check-label" for="facility1">AC</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="WiFi" id="facility2" name="facilities[]" {{ (is_array(old('facilities')) && in_array('WiFi', old('facilities'))) ? 'checked' : '' }}>
                <label class="form-check-label" for="facility2">WiFi</label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Kursi" id="facility3" name="facilities[]" {{ (is_array(old('facilities')) && in_array('Kursi', old('facilities'))) ? 'checked' : '' }}>
                <label class="form-check-label" for="facility3">Kursi</label>
            </div>
            <!-- Tambah fasilitas lain sesuai kebutuhan -->
        </div>
        
        <div class="mb-3">
            <label for="price_per_hour" class="form-label">Harga per Jam (Rp)</label>
            <input type="number" class="form-control" id="price_per_hour" name="price_per_hour" min="0" step="1000" value="{{ old('price_per_hour') }}" required>
        </div>
        
        <div class="mb-3">
            <label for="image" class="form-label">Foto Studio (opsional)</label>
            <input class="form-control" type="file" id="image" name="image" accept="image/*">
        </div>
        
        <button type="submit" class="btn btn-primary">Simpan</button>
        <a href="{{ route('admin.studios.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
