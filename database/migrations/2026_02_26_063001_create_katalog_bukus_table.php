<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('katalog_bukus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('form_submission_id')->nullable()->constrained('form_submissions')->nullOnDelete();
            $table->string('judul_penanggung_jawab');
            $table->string('edisi')->nullable();
            $table->string('publikasi')->nullable();
            $table->string('deskripsi_fisik')->nullable();
            $table->string('identifikasi')->nullable();
            $table->string('subjek')->nullable();
            $table->string('klasifikasi')->nullable();
            $table->text('sinopsis')->nullable();
            $table->string('cover')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('katalog_bukus');
    }
};
