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
        Schema::create('kliping_digitals', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->string('source'); // Media
            $table->string('topic')->nullable(); // Rubrik
            $table->string('page_number')->nullable();
            $table->date('published_at');
            $table->string('url')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kliping_digitals');
    }
};
