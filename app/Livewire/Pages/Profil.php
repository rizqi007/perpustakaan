<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use App\Models\LibraryProfile;

class Profil extends Component
{
    public function render()
    {
        return view('livewire.pages.profil', [
            'profile' => LibraryProfile::first()
        ])->layout('layouts.public');
    }
}
