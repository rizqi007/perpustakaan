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
        // Update Profil -> Profil & Sejarah Perpustakaan
        \DB::table('navigation_menus')
            ->where('label', 'Profil')
            ->update(['label' => 'Profil & Sejarah Perpustakaan']);

        // Update Sejarah -> Profil Perpustakaan Balai
        \DB::table('navigation_menus')
            ->where('label', 'Sejarah')
            ->update([
                'label' => 'Profil Perpustakaan Balai',
                'route_name' => 'tentang.profil-balai'
            ]);
    }

    public function down(): void
    {
        \DB::table('navigation_menus')
            ->where('label', 'Profil & Sejarah Perpustakaan')
            ->update(['label' => 'Profil']);

        \DB::table('navigation_menus')
            ->where('label', 'Profil Perpustakaan Balai')
            ->update([
                'label' => 'Sejarah',
                'route_name' => 'tentang.sejarah'
            ]);
    }
};
