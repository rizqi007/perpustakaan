<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResensiNavigationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if menu already exists
        $exists = DB::table('navigation_menus')->where('label', 'Resensi')->exists();

        if (!$exists) {
            DB::table('navigation_menus')->insert([
                'label' => 'Resensi',
                'url' => '/resensi',
                'route_name' => 'resensi.index', // Matches the name defined in web.php
                'order' => 5, // Adjust based on desired position
                'is_active' => true,
                'open_in_new_tab' => false,
                'parent_id' => null, // Top level menu
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
