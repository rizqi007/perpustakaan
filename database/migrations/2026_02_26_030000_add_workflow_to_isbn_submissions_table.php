<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('isbn_submissions', function (Blueprint $table) {
            // Workflow status (8 tahap proses)
            $table->string('workflow_status')->default('data_diterima')->after('status');

            // Instansi information (diisi oleh user)
            $table->enum('instansi_type', ['kanwil', 'kemenag', 'madrasah'])->default('madrasah')->after('workflow_status');
            $table->string('instansi_name')->nullable()->after('instansi_type');

            // Admin fills when status = perlu_diperbaiki
            $table->text('revision_notes')->nullable()->after('instansi_name');

            // Admin fills when status = isbn_terbit
            $table->string('isbn_number', 30)->nullable()->after('revision_notes');

            // Workflow tracking
            $table->timestamp('workflow_updated_at')->nullable()->after('isbn_number');
            $table->foreignId('workflow_updated_by')->nullable()->constrained('users')->onDelete('set null')->after('workflow_updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('isbn_submissions', function (Blueprint $table) {
            $table->dropForeign(['workflow_updated_by']);
            $table->dropColumn([
                'workflow_status',
                'instansi_type',
                'instansi_name',
                'revision_notes',
                'isbn_number',
                'workflow_updated_at',
                'workflow_updated_by',
            ]);
        });
    }
};
