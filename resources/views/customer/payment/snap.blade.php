@extends('layouts.customer')

@section('title', 'Pembayaran')

@section('content')
<div class="container mt-5 text-center">
    <h3>Silakan Selesaikan Pembayaran</h3>
    <button id="pay-button" class="btn btn-success mt-3">Bayar Sekarang</button>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').addEventListener('click', function () {
        snap.pay('{{ $snapToken }}');
    });
</script>
@endsection
