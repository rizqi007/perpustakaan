<?php

namespace App\Http\Controllers;

use App\Models\SejarahPerpustakaan;
use Illuminate\Http\Request;

class SejarahController extends Controller
{
    /**
     * Menampilkan halaman sejarah perpustakaan
     */
    public function index()
    {
        // Mengambil data sejarah yang aktif dan terurut
        $sejarah = SejarahPerpustakaan::active()
            ->ordered()
            ->get();

        return view('tentang.sejarah', compact('sejarah'));
    }

    /**
     * Alias untuk method index (jika ada yang memanggil sejarah())
     */
    public function sejarah()
    {
        return $this->index();
    }
}