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
        Schema::create('card_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->enum('orientation', ['horizontal', 'vertical'])->default('horizontal');
            $table->string('background_image')->nullable();
            $table->string('overlay_color', 20)->default('#047857');
            $table->float('overlay_opacity')->default(0.7);
            $table->json('logo_position')->nullable();
            $table->json('photo_position')->nullable();
            $table->json('name_position')->nullable();
            $table->json('nip_position')->nullable();
            $table->json('institution_position')->nullable();
            $table->json('validity_position')->nullable();
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_templates');
    }
};
