<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Hadir - {{ $form->title }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #1a1a2e;
            background: #fff;
        }

        /* ── HEADER ── */
        .header {
            background: linear-gradient(135deg, #065f46 0%, #047857 50%, #059669 100%);
            color: white;
            padding: 24px 28px 20px;
            margin-bottom: 0;
        }
        .header-top {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-bottom: 12px;
        }
        .header-logo {
            width: 52px;
            height: 52px;
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }
        .header-title h1 {
            font-size: 18px;
            font-weight: 700;
            letter-spacing: 0.3px;
            margin-bottom: 3px;
        }
        .header-title p {
            font-size: 11px;
            opacity: 0.85;
        }
        .header-meta {
            display: flex;
            gap: 20px;
            font-size: 10px;
            background: rgba(0,0,0,0.15);
            border-radius: 8px;
            padding: 8px 12px;
        }
        .header-meta span { opacity: 0.9; }
        .header-meta strong { opacity: 1; }

        /* ── INFO BADGES ── */
        .info-bar {
            background: #f0fdf4;
            border-bottom: 2px solid #bbf7d0;
            padding: 10px 28px;
            display: flex;
            gap: 24px;
            align-items: center;
        }
        .badge {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #dcfce7;
            border: 1px solid #86efac;
            border-radius: 6px;
            padding: 4px 10px;
            font-size: 10px;
            color: #166534;
            font-weight: 600;
        }
        .badge-blue {
            background: #dbeafe;
            border-color: #93c5fd;
            color: #1e40af;
        }
        .badge-orange {
            background: #fff7ed;
            border-color: #fdba74;
            color: #9a3412;
        }

        /* ── TABLE ── */
        .table-wrapper {
            padding: 20px 28px 28px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 1px 6px rgba(0,0,0,0.08);
        }
        thead tr {
            background: #064e3b;
            color: white;
        }
        thead th {
            padding: 11px 12px;
            text-align: left;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            white-space: nowrap;
        }
        thead th:first-child { border-radius: 0; width: 36px; text-align: center; }

        tbody tr:nth-child(even) { background: #f0fdf4; }
        tbody tr:nth-child(odd)  { background: #ffffff; }
        tbody tr:hover            { background: #dcfce7; }

        tbody td {
            padding: 9px 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10.5px;
            color: #374151;
            vertical-align: top;
        }
        tbody td:first-child {
            text-align: center;
            font-weight: 700;
            color: #6b7280;
            font-size: 10px;
        }
        tbody td.date-col {
            white-space: nowrap;
            color: #6b7280;
            font-size: 10px;
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 48px 20px;
            color: #9ca3af;
        }

        /* ── FOOTER ── */
        .footer {
            margin-top: 24px;
            padding: 12px 28px;
            border-top: 1px solid #e5e7eb;
            display: flex;
            justify-content: space-between;
            font-size: 9px;
            color: #9ca3af;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <div class="header">
        <div class="header-top">
            <div class="header-logo">📋</div>
            <div class="header-title">
                <h1>DAFTAR HADIR</h1>
                <p>{{ $form->title }}</p>
            </div>
        </div>
        <div class="header-meta">
            @if($form->start_date || $form->end_date)
                <span>📅 Periode: <strong>
                    {{ $form->start_date ? $form->start_date->format('d M Y') : '' }}
                    {{ $form->end_date ? ' s/d ' . $form->end_date->format('d M Y') : '' }}
                </strong></span>
            @endif
            <span>👥 Total Peserta: <strong>{{ $submissions->count() }} orang</strong></span>
            @if($form->max_quota)
                <span>🎯 Kuota: <strong>{{ $form->max_quota }} orang</strong></span>
            @endif
            <span>🖨️ Dicetak: <strong>{{ now()->format('d M Y, H:i') }} WIB</strong></span>
        </div>
    </div>

    {{-- TABLE --}}
    <div class="table-wrapper">
        @if($submissions->isEmpty())
            <div class="empty-state">
                <p>Belum ada data kehadiran untuk acara ini.</p>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        @foreach($fieldLabels as $label)
                            @if(strtolower($label) !== 'kegiatan')
                                <th>{{ $label }}</th>
                            @endif
                        @endforeach
                        {{-- Extra keys not in fieldLabels --}}
                        @foreach($extraKeys as $key)
                            @if(strtolower($key) !== 'kegiatan')
                                <th>{{ $key }}</th>
                            @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $i => $submission)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td class="date-col">{{ $submission->created_at->format('d/m/Y') }}<br><span style="font-size:9px;">{{ $submission->created_at->format('H:i') }}</span></td>
                            @foreach($fieldLabels as $label)
                                @if(strtolower($label) !== 'kegiatan')
                                    <td>{{ $submission->data[$label] ?? '-' }}</td>
                                @endif
                            @endforeach
                            @foreach($extraKeys as $key)
                                @if(strtolower($key) !== 'kegiatan')
                                    <td>{{ $submission->data[$key] ?? '-' }}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <span>Sistem Perpustakaan — Dokumen Resmi</span>
        <span>Digenerate otomatis pada {{ now()->format('d M Y H:i:s') }}</span>
    </div>

</body>
</html>
