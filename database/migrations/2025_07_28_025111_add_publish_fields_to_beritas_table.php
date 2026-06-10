<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * This method is executed when the migration is run. It adds the
     * 'is_published' and 'published_at' columns to the 'beritas' table.
     */
    public function up(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            // Add a boolean column to track the published status.
            // Defaults to 'true' (published) for any existing records.
            $table->boolean('is_published')->default(true)->after('image');

            // Add a timestamp column to store the date and time of publication.
            // This can be null if an article is a draft.
            $table->timestamp('published_at')->nullable()->after('is_published');
        });
    }

    /**
     * Reverse the migrations.
     *
     * This method is executed when the migration is rolled back. It removes the
     * columns that were added in the 'up' method.
     */
    public function down(): void
    {
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropColumn('is_published');
            $table->dropColumn('published_at');
        });
    }
};
