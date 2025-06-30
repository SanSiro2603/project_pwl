@extends('layouts.customer')

@section('title', 'Bayar Booking')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4 text-primary fw-bold">Pembayaran Booking</h1>
    <p>Booking untuk studio: <strong>{{ $booking->studio->name }}</strong></p>
    <p>Total yang harus dibayar: <strong>Rp {{ number_format($booking->total_price, 0, ',', '.') }}</strong></p>

    <button id="pay-button" class="btn btn-success">Bayar Sekarang</button>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay("{{ $snapToken }}", {
            onSuccess: function(result) {
                alert("Pembayaran berhasil!");
                window.location.href = "{{ route('customer.bookings.index') }}";
                window.location.href = "{{ route('customer.bookings.index') }}";

            },
            onPending: function(result) {
                alert("Pembayaran dalam proses. Silakan cek status di halaman booking.");
                window.location.href = "{{ route('customer.bookings.index') }}";
                window.location.href = "{{ route('customer.bookings.index') }}";

            },
            onError: function(result) {
                console.error(result);
                alert("Terjadi kesalahan dalam pembayaran.");
            },
            onClose: function() {
                alert("Anda menutup popup tanpa menyelesaikan pembayaran.");
            }
        });
    });
</script>
@endsection
