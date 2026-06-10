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
        Schema::table('anggotas', function (Blueprint $table) {
            $table->unsignedInteger('member_type_id')->default(1)->after('birth_date');
            $table->text('alamat_surat')->nullable()->after('alamat');
            $table->string('kode_pos')->nullable()->after('alamat_surat');
            $table->string('no_faks')->nullable()->after('no_hp');
            $table->date('member_since_date')->nullable()->after('foto');
            $table->date('register_date')->nullable()->after('member_since_date');
            $table->date('expire_date')->nullable()->after('register_date');
            $table->text('catatan')->nullable()->after('expire_date');
            $table->boolean('is_pending')->default(false)->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropColumn([
                'member_type_id',
                'alamat_surat',
                'kode_pos',
                'no_faks',
                'member_since_date',
                'register_date',
                'expire_date',
                'catatan',
                'is_pending'
            ]);
        });
    }
};
