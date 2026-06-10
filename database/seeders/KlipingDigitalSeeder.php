<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NavigationMenu;

class KlipingDigitalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kliping = NavigationMenu::where('label', 'Kliping Digital')->first();

        if (!$kliping) {
            NavigationMenu::create([
                'label' => 'Kliping Digital',
                'route_name' => 'kliping.index',
                'url' => null,
                'open_in_new_tab' => false,
                'order' => 5, // Adjust order as needed
                'is_active' => true,
                'parent_id' => null,
            ]);
        }
    }
}
