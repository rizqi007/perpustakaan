<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class ProfilBalaiDetail extends Component
{
    public $profil;

    public function mount($slug)
    {
        $this->profil = \App\Models\ProfilBalai::where('slug', $slug)->firstOrFail();
    }

    public function render()
    {
        return view('livewire.pages.profil-balai-detail')
            ->layout('layouts.public');
    }
}
