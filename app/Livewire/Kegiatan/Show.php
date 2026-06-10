<?php

namespace App\Livewire\Kegiatan;

use Livewire\Component;
use App\Models\Kegiatan;

class Show extends Component
{
    public Kegiatan $kegiatan;

    public function mount($slug)
    {
        $this->kegiatan = Kegiatan::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.kegiatan.show')
            ->layout('layouts.public', ['title' => $this->kegiatan->judul]);
    }
}
