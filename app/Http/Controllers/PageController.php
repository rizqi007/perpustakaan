<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\Banner; 

class PageController extends Controller
{
    /**
     * Menampilkan halaman utama.
     */
    public function home()
    {
        // Contoh: Ambil data banner jika ada
        // $banners = \App\Models\Banner::where('is_active', true)->get();
        // return view('home', compact('banners'));

        // Untuk sekarang, kita asumsikan $banners kosong agar fallback content muncul
        $banners = collect();
        return view('home', compact('banners'));
    }

    /**
     * Menampilkan halaman profil.
     */
    public function profil()
    {
        return view('tentang.profil');
    }

    /**
     * Menampilkan halaman sejarah.
     */
    public function sejarah()
    {
        return view('tentang.sejarah');
    }

    /**
     * Menampilkan halaman keanggotaan.
     */
    public function keanggotaan()
    {
        return view('layanan.keanggotaan');
    }

    /**
     * Menampilkan halaman katalog online.
     */
  public function katalogOnline()
    {
        // Diperbaiki: Menggunakan tanda hubung (-) agar sesuai dengan nama file view.
        return view('layanan.katalog-online');
    }
}
