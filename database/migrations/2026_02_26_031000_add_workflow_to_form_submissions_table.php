<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->string('workflow_status')->default('data_diterima')->after('status');
            $table->text('revision_notes')->nullable()->after('workflow_status');
            $table->string('isbn_number', 30)->nullable()->after('revision_notes');
            $table->timestamp('workflow_updated_at')->nullable()->after('isbn_number');
            $table->foreignId('workflow_updated_by')->nullable()->constrained('users')->onDelete('set null')->after('workflow_updated_at');
        });
    }

    public function down(): void
    {
        Schema::table('form_submissions', function (Blueprint $table) {
            $table->dropForeign(['workflow_updated_by']);
            $table->dropColumn(['workflow_status', 'revision_notes', 'isbn_number', 'workflow_updated_at', 'workflow_updated_by']);
        });
    }
};
