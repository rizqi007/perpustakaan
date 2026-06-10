<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->string('email')->nullable()->after('nama');
            $table->string('no_hp')->nullable()->after('email');
            $table->text('alamat')->nullable()->after('no_hp');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('foto');
            $table->text('catatan_admin')->nullable()->after('status');
            $table->timestamp('approved_at')->nullable()->after('catatan_admin');
        });
    }

    public function down(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropColumn(['email', 'no_hp', 'alamat', 'status', 'catatan_admin', 'approved_at']);
        });
    }
};
