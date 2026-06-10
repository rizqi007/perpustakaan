<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Berita;
use App\Models\Layanan;
use App\Models\Testimoni;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        // Ambil banner yang aktif
        $banners = Banner::where('is_active', true)->latest()->get();

        // Ambil semua layanan
        $layanans = Layanan::latest()->get();

        // Ambil 6 berita terbaru
        $beritas = Berita::latest()->take(6)->get();

        // Ambil 4 testimoni terbaru
        $testimonis = Testimoni::latest()->take(4)->get();

        return view('welcome', compact('banners', 'layanans', 'beritas', 'testimonis'));
    }
}