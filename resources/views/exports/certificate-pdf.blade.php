@php
    // Encode images to Base64 to prevent path space or SSL/local resolution errors in Dompdf
    $logoBase64 = null;
    $logoPath = public_path('images/logo.png');
    if (file_exists($logoPath)) {
        $logoBase64 = 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath));
    }

    $bgBase64 = null;
    if ($certificate->background_image) {
        $bgPath = public_path('storage/' . $certificate->background_image);
        if (file_exists($bgPath)) {
            $mimeType = mime_content_type($bgPath);
            $bgBase64 = 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($bgPath));
        }
    }

    $signatureBase64 = null;
    if ($certificate->signature_image) {
        $signaturePath = public_path('storage/' . $certificate->signature_image);
        if (file_exists($signaturePath)) {
            $mimeType = mime_content_type($signaturePath);
            $signatureBase64 = 'data:' . $mimeType . ';base64,' . base64_encode(file_get_contents($signaturePath));
        }
    }

    // Pre-format date to avoid IDE static-analysis warnings
    $formattedDate = isset($form->start_date) && $form->start_date
        ? $form->start_date->format('d M Y')
        : now()->format('d M Y');
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Sertifikat Kehadiran</title>
    <style>
        @page {
            size: 297mm 210mm;
            margin: 0;
        }
        * {
            margin: 0;
            padding: 0;
        }
        body {
            width: 297mm;
            height: 210mm;
            font-family: 'DejaVu Sans', 'Helvetica', sans-serif;
            color: #1f2937;
        }

        /* ===== Page Container ===== */
        .page {
            position: relative;
            width: 297mm;
            height: 210mm;
            overflow: hidden;
        }

        /* ===== CUSTOM TEMPLATE (uploaded background) ===== */
        .custom-bg {
            background-size: 100% 100%;
            background-repeat: no-repeat;
        }
        .custom-name {
            position: absolute;
            left: 20mm;
            right: 20mm;
            text-align: center;
        }

        /* ===== DEFAULT ELEGANT TEMPLATE ===== */
        .default-bg {
            background-color: #fdfcf8;
        }

        /* Watermark: centered on page (297-70)/2=113.5, (210-70)/2=70 */
        .watermark {
            position: absolute;
            width: 70mm;
            height: 70mm;
            top: 70mm;
            left: 113.5mm;
            opacity: 0.04;
        }

        /* Outer border: 8mm inset */
        .border-outer {
            position: absolute;
            top: 8mm;
            left: 8mm;
            right: 8mm;
            bottom: 8mm;
            border: 3px double #065f46;
        }

        /* Inner border: 3mm inside outer */
        .border-inner {
            position: absolute;
            top: 3mm;
            left: 3mm;
            right: 3mm;
            bottom: 3mm;
            border: 1.5px solid #c88c1a;
        }

        /* Corner accents */
        .corner {
            position: absolute;
            width: 20px;
            height: 20px;
            border-color: #c88c1a;
            border-style: solid;
        }
        .c-tl { top: -1px; left: -1px; border-width: 3px 0 0 3px; }
        .c-tr { top: -1px; right: -1px; border-width: 3px 3px 0 0; }
        .c-bl { bottom: -1px; left: -1px; border-width: 0 0 3px 3px; }
        .c-br { bottom: -1px; right: -1px; border-width: 0 3px 3px 0; }

        /* Main content block: positioned from page root */
        .content {
            position: absolute;
            top: 16mm;
            left: 22mm;
            right: 22mm;
            text-align: center;
        }
        .logo {
            height: 36px;
            margin-bottom: 2mm;
        }
        .org-name {
            font-size: 9pt;
            font-weight: bold;
            color: #065f46;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 4mm;
        }
        .cert-title {
            font-family: 'DejaVu Serif', 'Times', serif;
            font-size: 32pt;
            font-weight: bold;
            color: #d97706;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 1mm;
        }
        .cert-no {
            font-size: 8pt;
            color: #6b7280;
            letter-spacing: 1px;
            margin-bottom: 5mm;
        }
        .given-to {
            font-family: 'DejaVu Serif', serif;
            font-style: italic;
            font-size: 11pt;
            color: #4b5563;
            margin-bottom: 2mm;
        }
        .attendee-name {
            font-family: 'DejaVu Serif', serif;
            font-weight: bold;
            margin-bottom: 4mm;
            line-height: 1.2;
        }
        .cert-desc {
            font-size: 9pt;
            color: #4b5563;
            line-height: 1.6;
        }

        /* Footer: positioned from page root bottom */
        .footer-wrap {
            position: absolute;
            bottom: 14mm;
            left: 22mm;
            right: 22mm;
        }
        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }
        .footer-table td {
            width: 50%;
            text-align: center;
            vertical-align: top;
            padding: 0 10mm;
        }
        .signer-label {
            font-size: 8pt;
            font-weight: bold;
            color: #4b5563;
            text-transform: uppercase;
            letter-spacing: 1px;
            line-height: 1.4;
            margin-bottom: 10mm;
        }
        .sig-img {
            max-height: 35px;
            max-width: 120px;
        }
        .signer-name {
            font-size: 9pt;
            font-weight: bold;
            color: #1f2937;
            text-decoration: underline;
        }
        .signer-sub {
            font-size: 7pt;
            color: #6b7280;
            margin-top: 2px;
        }
    </style>
</head>
<body>@if($bgBase64)<div class="page custom-bg" style="background-image:url('{{ $bgBase64 }}');"><div class="custom-name" style="top:{{ $certificate->name_y }}%;"><span style="font-size:{{ $certificate->name_font_size }}pt;color:{{ $certificate->name_color }};font-weight:bold;">{{ $name }}</span></div></div>@else<div class="page default-bg">
@if($logoBase64)<img src="{{ $logoBase64 }}" class="watermark" />@endif
<div class="border-outer">
<div class="border-inner">
<div class="corner c-tl"></div>
<div class="corner c-tr"></div>
<div class="corner c-bl"></div>
<div class="corner c-br"></div>
</div>
</div>
<div class="content">
@if($logoBase64)<img src="{{ $logoBase64 }}" class="logo" />@endif
<div class="org-name">Perpustakaan Kementerian Agama RI</div>
<div class="cert-title">Sertifikat</div>
<div class="cert-no">No: CERT/{{ $submission->id }}/{{ now()->format('Y') }}</div>
<div class="given-to">Diberikan kepada:</div>
<div class="attendee-name" style="font-size:{{ $certificate->name_font_size }}pt;color:{{ $certificate->name_color }};">{{ $name }}</div>
<div class="cert-desc">{{ $certificate->description ?: 'Atas partisipasinya yang luar biasa sebagai peserta dalam ' . ($form->title ?? 'Acara') . ' yang diselenggarakan oleh Perpustakaan Kementerian Agama RI.' }}</div>
</div>
<div class="footer-wrap">
<table class="footer-table">
<tr>
<td>
<div class="signer-label">Penyelenggara</div>
<div style="height:35px;"></div>
<div class="signer-name">Panitia Pelaksana</div>
<div class="signer-sub">Perpustakaan Kemenag RI</div>
</td>
<td>
<div class="signer-label">Jakarta, {{ $formattedDate }}<br>{{ $certificate->signature_title ?: 'Kepala Perpustakaan' }}</div>
<div style="height:35px;">@if($signatureBase64)<img src="{{ $signatureBase64 }}" class="sig-img" />@endif</div>
<div class="signer-name">{{ $certificate->signature_name ?: 'Kepala Perpustakaan Kemenag' }}</div>
<div class="signer-sub">Kementerian Agama RI</div>
</td>
</tr>
</table>
</div>
</div>@endif</body>
</html>
