<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    /**
     * Menampilkan daftar semua berita dengan paginasi.
     */
    public function index()
    {
        $beritas = Berita::latest()->paginate(9);
        return view('berita.index', compact('beritas'));
    }

    /**
     * Menampilkan detail satu berita berdasarkan slug-nya.
     */
    public function show(Berita $berita)
    {
        // Kirim data berita yang ditemukan ke view 'show'
        return view('berita.show', compact('berita'));
    }
}