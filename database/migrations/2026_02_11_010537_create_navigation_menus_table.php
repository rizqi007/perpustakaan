<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('navigation_menus', function (Blueprint $table) {
            $table->id();
            $table->string('label');           // Display text (e.g. "Beranda")
            $table->string('url')->nullable(); // URL or route path
            $table->string('route_name')->nullable(); // Laravel route name (e.g. 'landing')
            $table->foreignId('parent_id')->nullable()->constrained('navigation_menus')->cascadeOnDelete();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->boolean('open_in_new_tab')->default(false);
            $table->string('icon')->nullable(); // Optional icon class
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('navigation_menus');
    }
};
