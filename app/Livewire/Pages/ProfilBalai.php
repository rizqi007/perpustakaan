<?php

namespace App\Livewire\Pages;

use Livewire\Component;

use App\Models\ProfilBalai as ProfilBalaiModel;

class ProfilBalai extends Component
{
    public function render()
    {
        return view('livewire.pages.profil-balai', [
            'profils' => ProfilBalaiModel::all()
        ])->layout('layouts.public');
    }
}
