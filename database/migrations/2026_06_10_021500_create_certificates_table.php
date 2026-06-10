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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('form_id')->unique();
            $table->string('title');
            $table->string('background_image')->nullable();
            $table->string('name_field')->default('Nama');
            $table->integer('name_y')->default(45);
            $table->integer('name_font_size')->default(36);
            $table->string('name_color')->default('#1f2937');
            $table->string('name_font_family')->default('Great Vibes');
            $table->text('description')->nullable();
            $table->string('signature_name')->nullable();
            $table->string('signature_title')->nullable();
            $table->string('signature_image')->nullable();
            $table->timestamps();

            $table->foreign('form_id')->references('id')->on('forms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
