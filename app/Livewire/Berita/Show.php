<?php

namespace App\Livewire\Berita;

use Livewire\Component;
use App\Models\Berita;

class Show extends Component
{
    public $slug;
    public $berita;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->berita = Berita::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.berita.show', [
            'berita' => $this->berita,
            'recent_posts' => Berita::where('id', '!=', $this->berita->id)->latest()->take(5)->get()
        ])->layout('layouts.public');
    }
}
