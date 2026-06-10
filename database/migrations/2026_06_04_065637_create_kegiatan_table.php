<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kegiatan', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('slug')->unique();
            $table->enum('kategori', ['seminar', 'bedah_buku', 'workshop', 'diskusi', 'pameran', 'lainnya'])->default('lainnya');
            $table->text('deskripsi')->nullable();
            $table->string('cover_image')->nullable();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->string('lokasi')->nullable();
            $table->json('narasumber')->nullable(); // Array of {nama, jabatan, foto}
            $table->string('file_paparan')->nullable(); // PDF/PPT upload
            $table->string('file_artikel')->nullable(); // PDF article
            $table->string('link_rekaman')->nullable(); // YouTube/video link
            $table->string('link_dokumentasi')->nullable(); // Photo album link
            $table->json('galeri')->nullable(); // Array of image paths
            $table->integer('jumlah_peserta')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kegiatan');
    }
};
