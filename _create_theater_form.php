<?php

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$fields = [
    [
        'type' => 'text',
        'label' => 'Nama PIC',
        'required' => true,
        'helper_text' => null,
        'options' => []
    ],
    [
        'type' => 'text',
        'label' => 'Asal Instansi',
        'required' => true,
        'helper_text' => null,
        'options' => []
    ],
    [
        'type' => 'email',
        'label' => 'Email PIC',
        'required' => true,
        'helper_text' => null,
        'options' => []
    ],
    [
        'type' => 'text',
        'label' => 'Nomor WhatsApp PIC',
        'required' => true,
        'helper_text' => 'Masukkan nomor aktif, contoh: 081234567890',
        'options' => []
    ],
    [
        'type' => 'number',
        'label' => 'Jumlah Peserta',
        'required' => true,
        'helper_text' => 'Kapasitas maksimal 26 seat',
        'options' => []
    ],
    [
        'type' => 'date',
        'label' => 'Tanggal Kegiatan',
        'required' => true,
        'helper_text' => null,
        'options' => []
    ],
    [
        'type' => 'select',
        'label' => 'Waktu Kegiatan',
        'required' => true,
        'helper_text' => 'Pilih salah satu sesi',
        'options' => [
            '09:00 - 11:00 WIB' => '09:00 - 11:00 WIB',
            '13:00 - 15:00 WIB' => '13:00 - 15:00 WIB'
        ]
    ],
    [
        'type' => 'number',
        'label' => 'Durasi Acara (isi Angka 1-7 (jam))',
        'required' => true,
        'helper_text' => 'Masukkan angka durasi kegiatan dalam jam',
        'options' => []
    ],
    [
        'type' => 'select_with_input',
        'label' => 'Tujuan Peminjaman',
        'required' => true,
        'helper_text' => null,
        'options' => [
            'Nonton dan Diskusi Film Moderasi Beragama' => 'Nonton dan Diskusi Film Moderasi Beragama',
            'Nonton dan Diskusi Film sesuai Request' => 'Nonton dan Diskusi Film sesuai Request',
            'Diskusi' => 'Diskusi',
            'Rapat' => 'Rapat',
            'Seminar / Workshop' => 'Seminar / Workshop',
            'Podcast' => 'Podcast'
        ]
    ],
    [
        'type' => 'file',
        'label' => 'Upload Surat Pengajuan Peminjaman Mini Theater BMBPSDM',
        'required' => true,
        'helper_text' => 'Hanya PDF yang didukung. PDF Maks 100 MB',
        'options' => []
    ]
];

$data = [
    'title' => 'Formulir Peminjaman Mini Theater',
    'slug' => 'peminjaman-mini-theater',
    'description' => <<<'HTML'
<div class="space-y-4">
    <p class="text-gray-700 dark:text-gray-300">
        Mini Theater Perpustakaan BMBPSDM Kementerian Agama berlokasi di Kantor Kementerian Agama Jl. M.H. Thamrin No.6 Lantai 2.
    </p>
    
    <div class="bg-emerald-50/50 dark:bg-emerald-950/20 border border-emerald-100 dark:border-emerald-900/30 rounded-xl p-3 text-xs space-y-1">
        <div class="flex items-center gap-2 text-emerald-850 dark:text-emerald-400 font-bold mb-1">
            <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Layanan Mini Theater:</span>
        </div>
        <p class="text-gray-650 dark:text-gray-400 pl-6">
            <strong>Jam Buka:</strong> Senin - Kamis 09.00 - 15.00 WIB
        </p>
        <p class="text-gray-650 dark:text-gray-400 pl-6">
            <strong>Kapasitas Maksimal:</strong> 26 seat
        </p>
    </div>

    <div>
        <p class="font-bold text-gray-800 dark:text-gray-200 mb-2">Tahapan Pengisian:</p>
        <ol class="space-y-3">
            <li class="flex items-start gap-2.5">
                <span class="flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 flex items-center justify-center text-xs font-bold mt-0.5">1</span>
                <span class="text-gray-700 dark:text-gray-300">
                    Follow Instagram 
                    <a href="https://instagram.com/perpuskemenagri" target="_blank" class="text-emerald-600 dark:text-emerald-400 hover:underline font-medium inline-flex items-center gap-0.5">
                        @perpuskemenagri
                        <svg class="w-3.5 h-3.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </a>
                </span>
            </li>
            <li class="flex items-start gap-2.5">
                <span class="flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 flex items-center justify-center text-xs font-bold mt-0.5">2</span>
                <div class="space-y-1.5 flex-1">
                    <span class="text-gray-700 dark:text-gray-300 block">
                        Buat Surat Pengajuan Peminjaman Mini Theater BMBPSDM menggunakan template resmi.
                    </span>
                    <a href="https://docs.google.com/document/d/1BJfko27O51ZD22mHV4F6BF5lM1JuqWxb7U6vcuNGFkI/edit" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-lg shadow-sm transition w-full justify-center sm:w-auto mt-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                        Unduh Template Surat
                    </a>
                </div>
            </li>
            <li class="flex items-start gap-2.5">
                <span class="flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 flex items-center justify-center text-xs font-bold mt-0.5">3</span>
                <span class="text-gray-700 dark:text-gray-300">
                    PIC <strong class="text-emerald-700 dark:text-emerald-400">WAJIB MEMBUAT</strong> WhatsApp Group.
                </span>
            </li>
            <li class="flex items-start gap-2.5">
                <span class="flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 flex items-center justify-center text-xs font-bold mt-0.5">4</span>
                <span class="text-gray-700 dark:text-gray-300">
                    Unggah Surat Pengajuan Peminjaman Mini Theater BMBPSDM pada form ini.
                </span>
            </li>
            <li class="flex items-start gap-2.5">
                <span class="flex-shrink-0 w-5 h-5 rounded-full bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 flex items-center justify-center text-xs font-bold mt-0.5">5</span>
                <span class="text-gray-700 dark:text-gray-300">
                    PIC akan menerima konfirmasi via chat WhatsApp terkait status pengajuan (disetujui atau ditolak).
                </span>
            </li>
        </ol>
    </div>

    <div class="text-xs text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/20 border border-amber-100 dark:border-amber-900/30 p-3 rounded-xl flex items-start gap-2 mt-2">
        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <span>
            <strong>Catatan:</strong> Jika slot pengajuan dibatalkan, silakan mengulangi tahap pendaftaran dari awal.
        </span>
    </div>
</div>
HTML,
    'fields' => $fields,
    'participant_label' => 'Nama PIC',
    'quota_count_label' => 'Jumlah Peserta',
    'booking_date_label' => 'Tanggal Kegiatan',
    'time_slot_label' => 'Waktu Kegiatan',
    'is_active' => true,
    'max_quota' => 26,
    'start_date' => '2026-06-10',
    'end_date' => '2026-12-31',
    'ticket_bg_image' => 'ticket-templates/01KH3RAZW3VX0GKY157BJPXC8M.png',
    'ticket_name_x' => 54,
    'ticket_name_y' => 192,
    'ticket_name_size' => 32,
    'ticket_name_color' => '#000000',
    'ticket_date_x' => 68,
    'ticket_date_y' => 349,
    'ticket_date_size' => 20,
    'ticket_date_color' => '#333333',
];

$form = App\Models\Form::updateOrCreate(['slug' => 'peminjaman-mini-theater'], $data);

echo "Form peminjaman teater created or updated successfully! ID: " . $form->id . "\n";
