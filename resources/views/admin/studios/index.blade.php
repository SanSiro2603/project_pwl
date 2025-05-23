@extends('layouts.app')

@section('title', 'Kelola Studio')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-building"></i> Kelola Studio</h2>
        <a href="{{ route('admin.studios.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Studio
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Studio</h5>
        </div>
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Nama Studio</th>
                        <th>Harga / Jam</th>
                        <th>Fasilitas</th>
                        <th>Status</th>
                        <th width="150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($studios as $studio)
                    <tr>
                        <td>
                            @if($studio->image)
                                <img src="{{ asset('storage/' . $studio->image) }}" alt="{{ $studio->name }}" width="80" class="img-thumbnail">
                            @else
                                <span class="text-muted">Tidak ada</span>
                            @endif
                        </td>
                        <td>{{ $studio->name }}</td>
                        <td>{{ $studio->formatted_price }}</td>
                        <td>
                            <ul class="mb-0 ps-3">
                                @foreach($studio->facilities as $facility)
                                    <li>{{ $facility }}</li>
                                @endforeach
                            </ul>
                        </td>
                        <td>
                            <span class="badge bg-{{ $studio->is_active ? 'success' : 'secondary' }}">
                                {{ $studio->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.studios.edit', $studio->id) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.studios.destroy', $studio->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus studio ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Belum ada data studio.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
