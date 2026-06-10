<?php

namespace App\Livewire\Layanan;

use Livewire\Component;
use App\Models\Layanan;

class Index extends Component
{
    public function render()
    {
        return view('livewire.layanan.index', [
            'layanans' => Layanan::all()
        ])->layout('layouts.public');
    }
}
