<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonis', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('institution')->nullable(); // Instansi/Pekerjaan
            $table->text('quote');
            $table->string('photo')->nullable();
            $table->string('youtube_url')->nullable(); // Tambahkan kolom ini
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonis');
    }
};
