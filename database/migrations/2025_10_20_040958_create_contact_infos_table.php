<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contact_infos', function (Blueprint $table) {
            $table->id();
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('monday_thursday')->default('07:00 - 16:00');
            $table->string('friday')->default('07:00 - 16:30');
            $table->string('saturday')->default('Tutup');
            $table->string('sunday')->default('Tutup');
            $table->text('map_embed_url')->nullable();
            $table->string('map_latitude')->nullable();
            $table->string('map_longitude')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contact_infos');
    }
};