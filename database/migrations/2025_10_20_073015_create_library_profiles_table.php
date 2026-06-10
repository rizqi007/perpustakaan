<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('library_profiles', function (Blueprint $table) {
            $table->id();
            $table->text('visi');
            $table->json('misi');
            $table->string('tagline');
            $table->json('functions'); // Fungsi Perpustakaan Khusus
            $table->json('tasks'); // Tugas Perpustakaan Kemenag
            $table->json('legal_bases'); // Dasar Hukum
            $table->json('milestones'); // Milestone
            $table->json('collections'); // Koleksi
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('library_profiles');
    }
};