<?php

namespace App\Livewire\Resensi;

use App\Models\Resensi;
use Livewire\Component;

class Show extends Component
{
    public $resensi;

    public function mount($slug)
    {
        $this->resensi = Resensi::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.resensi.show')->layout('layouts.public');
    }
}
