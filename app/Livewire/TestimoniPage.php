<?php

namespace App\Livewire;

use Livewire\Component;

use Livewire\WithPagination;
use App\Models\Testimoni;

class TestimoniPage extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.testimoni-page', [
            'testimonis' => Testimoni::latest()->paginate(9)
        ])->layout('layouts.public');
    }
}
