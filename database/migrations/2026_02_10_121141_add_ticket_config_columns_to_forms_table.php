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
        Schema::table('forms', function (Blueprint $table) {
            $table->string('ticket_bg_image')->nullable()->after('is_active');
            
            // Name Text Config
            $table->integer('ticket_name_x')->default(60)->after('ticket_bg_image');
            $table->integer('ticket_name_y')->default(110)->after('ticket_name_x');
            $table->integer('ticket_name_size')->default(32)->after('ticket_name_y');
            $table->string('ticket_name_color')->default('#000000')->after('ticket_name_size');
            
            // Date Text Config
            $table->integer('ticket_date_x')->default(60)->after('ticket_name_color');
            $table->integer('ticket_date_y')->default(160)->after('ticket_date_x');
            $table->integer('ticket_date_size')->default(20)->after('ticket_date_y');
            $table->string('ticket_date_color')->default('#333333')->after('ticket_date_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('forms', function (Blueprint $table) {
            $table->dropColumn([
                'ticket_bg_image', 
                'ticket_name_x', 'ticket_name_y', 'ticket_name_size', 'ticket_name_color',
                'ticket_date_x', 'ticket_date_y', 'ticket_date_size', 'ticket_date_color'
            ]);
        });
    }
};
