<h2>Booking Studio Berhasil!</h2>
<p>Hi {{ $booking->user->name }},</p>
<p>Detail booking:</p>
<ul>
    <li>Tanggal: {{ $booking->tanggal }}</li>
    <li>Jam: {{ $booking->jam }}</li>
    <li>Durasi: {{ $booking->durasi }} jam</li>
    <li>Total: Rp{{ number_format($booking->total_biaya) }}</li>
</ul>
<p>Silakan lakukan pembayaran via QRIS.</p>

<p>Terima kasih!</p>