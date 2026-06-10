<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Banner;
use App\Models\Berita;
use App\Models\Layanan;
use App\Models\Testimoni;
use App\Models\Form;
use App\Models\FormSubmission;
use App\Models\IsbnSubmission;
use App\Models\Kegiatan;

class Home extends Component
{
    public $search = '';

    public function render()
    {
        $isbnBooks = \App\Models\KatalogBuku::latest()->take(8)->get();

        return view('livewire.home', [
            'banners' => Banner::where('is_active', true)->latest()->get(),
            'layanans' => Layanan::where('type', 'perpustakaan')
                ->where('name', 'like', '%' . $this->search . '%')
                ->latest()->get(),
            'openResources' => Layanan::where('type', 'open_resource')
                ->where('name', 'like', '%' . $this->search . '%')
                ->latest()->get(),
            'beritas' => Berita::latest()->take(6)->get(),

            'forms' => Form::where('is_active', true)
                ->where('slug', '!=', 'daftar-hadir-pengunjung')
                ->where('slug', 'not like', 'daftar-hadir-%')
                ->get(),
            'resensis' => \App\Models\Resensi::where('status', 'published')->latest()->take(5)->get(),
            'websiteSettings' => \App\Models\WebsiteSetting::get(),
            'isbnBooks' => $isbnBooks,
            'kegiatans' => Kegiatan::where('is_published', true)->latest('tanggal_mulai')->take(6)->get(),
        ])->layout('layouts.public');
    }
}
