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
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->boolean('buku_cetak_diserahkan')->default(false)->after('kdt_file');
            $table->boolean('buku_digital_diserahkan')->default(false)->after('buku_cetak_diserahkan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->dropColumn(['buku_cetak_diserahkan', 'buku_digital_diserahkan']);
        });
    }
};
