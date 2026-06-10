<!DOCTYPE html>
<html>
<head>
    <title>Booking Approved</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #047857; color: white; padding: 20px; text-align: center; border-radius: 8px 8px 0 0; }
        .content { border: 1px solid #e5e7eb; border-top: none; padding: 20px; border-radius: 0 0 8px 8px; }
        .button { display: inline-block; padding: 10px 20px; background: #047857; color: white; text-decoration: none; border-radius: 5px; margin-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Booking Disetujui!</h2>
        </div>
        <div class="content">
            <p>Halo, <strong>{{ data_get($submission->data, 'Nama') ?? data_get($submission->data, 'Name') ?? 'Sobat Pustaka' }}</strong>!</p>
            
            <p>Pengajuan pendaftaran "Nobar & Diskusi Film" Anda untuk tanggal:</p>
            <p style="font-size: 1.2em; font-weight: bold; color: #047857;">
                {{ $submission->booking_date ? $submission->booking_date->translatedFormat('l, d F Y') : 'Terjadwal' }}
            </p>
            
            <p>Telah <strong>DISETUJUI</strong> oleh Admin.</p>
            
            <p>Silakan unduh E-Ticket yang terlampir pada email ini dan tunjukkan kepada petugas saat kedatangan.</p>
            
            <br>
            <p>Terima kasih,<br>Perpustakaan Kemenag RI</p>
        </div>
    </div>
</body>
</html>
