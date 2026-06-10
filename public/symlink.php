<?php

// Path folder ASLI (tempat file tersimpan)
$target = '/home/bmbpsdmm/perpustakaan-digital/storage/app/public';

// Path SHORTCUT (yang akan dibuat di folder publik)
$link = '/home/bmbpsdmm/perpustakaan.bmbpsdm.my.id/storage';

echo "Target (Sumber): " . $target . "<br>";
echo "Link (Tujuan): " . $link . "<br><br>";

// Cek apakah target valid
if (!file_exists($target)) {
    echo "<h3>❌ ERROR: Folder target tidak ditemukan!</h3>";
    echo "Pastikan path target sudah benar: $target";
    exit;
}

// Cek apakah link sudah ada
if (file_exists($link)) {
    echo "<h3>⚠️ Symlink/Folder 'storage' sudah ada.</h3>";
    if (is_link($link)) {
        echo "Ini adalah symlink. Jika gambar masih rusak, coba hapus symlink ini di File Manager lalu jalankan script ini lagi.<br>";
        echo "Arah link saat ini: " . readlink($link);
    } else {
        echo "Ini adalah folder biasa (bukan symlink). Hapus folder ini dulu jika ingin membuat symlink baru.";
    }
} else {
    try {
        symlink($target, $link);
        echo "<h3>✅ BERHASIL! Symlink storage telah dibuat.</h3>";
        echo "Cek website Anda sekarang.";
    } catch (Exception $e) {
        echo "<h3>❌ GAGAL: " . $e->getMessage() . "</h3>";
    }
}
