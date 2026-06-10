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
        Schema::create('trash_bins', function (Blueprint $table) {
            $table->id();
            $table->string('model_type');
            $table->string('model_id');
            $table->string('label')->nullable();
            $table->longText('payload');
            $table->string('deleted_by')->nullable();
            $table->timestamps();

            // Index for faster queries
            $table->index(['model_type', 'model_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trash_bins');
    }
};
