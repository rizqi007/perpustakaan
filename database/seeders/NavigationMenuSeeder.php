<?php

namespace Database\Seeders;

use App\Models\NavigationMenu;
use Illuminate\Database\Seeder;

class NavigationMenuSeeder extends Seeder
{
    public function run(): void
    {
        // Clear existing menus
        NavigationMenu::truncate();

        // 1. Beranda
        NavigationMenu::create([
            'label' => 'Beranda',
            'url' => '/',
            'route_name' => 'landing',
            'order' => 1,
            'is_active' => true,
        ]);

        // 2. Tentang Kami (parent)
        $tentangKami = NavigationMenu::create([
            'label' => 'Tentang Kami',
            'url' => '#',
            'route_name' => null,
            'order' => 2,
            'is_active' => true,
        ]);

        // 2.1 Profil (child)
        NavigationMenu::create([
            'label' => 'Profil',
            'url' => '/tentang/profil',
            'route_name' => 'tentang.profil',
            'parent_id' => $tentangKami->id,
            'order' => 1,
            'is_active' => true,
        ]);

        // 2.2 Sejarah (child)
        NavigationMenu::create([
            'label' => 'Sejarah',
            'url' => '/tentang/sejarah',
            'route_name' => 'tentang.sejarah',
            'parent_id' => $tentangKami->id,
            'order' => 2,
            'is_active' => true,
        ]);

        // 3. Berita
        NavigationMenu::create([
            'label' => 'Berita',
            'url' => '/berita',
            'route_name' => 'berita.index',
            'order' => 3,
            'is_active' => true,
        ]);

        // 4. Hubungi Kami
        NavigationMenu::create([
            'label' => 'Hubungi Kami',
            'url' => '/contact',
            'route_name' => 'contact',
            'order' => 4,
            'is_active' => true,
        ]);

        // 5. Testimoni
        NavigationMenu::create([
            'label' => 'Testimoni',
            'url' => '#',
            'route_name' => null,
            'order' => 5,
            'is_active' => true,
        ]);
    }
}
