<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\User;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('unique_slug', 12)->unique()->nullable()->after('email');
        });

        // Generate unique slug for existing users
        User::whereNull('unique_slug')->each(function ($user) {
            $user->update(['unique_slug' => Str::random(10)]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('unique_slug');
        });
    }
};
