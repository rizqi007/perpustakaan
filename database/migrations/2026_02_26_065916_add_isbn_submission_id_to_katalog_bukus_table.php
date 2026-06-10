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
        Schema::table('katalog_bukus', function (Blueprint $table) {
            $table->foreignId('isbn_submission_id')->nullable()->after('form_submission_id')->constrained('isbn_submissions')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('katalog_bukus', function (Blueprint $table) {
            $table->dropForeign(['isbn_submission_id']);
            $table->dropColumn('isbn_submission_id');
        });
    }
};
