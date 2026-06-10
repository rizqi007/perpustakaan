<?php

namespace App\Livewire\Resensi;

use App\Models\Resensi;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.resensi.index', [
            'resensis' => Resensi::where('status', 'published')
                ->latest('published_at')
                ->paginate(9),
        ])->layout('layouts.public');
    }
}
