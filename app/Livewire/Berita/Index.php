<?php

namespace App\Livewire\Berita;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Berita;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $beritas = Berita::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(9);

        return view('livewire.berita.index', [
            'beritas' => $beritas
        ])->layout('layouts.public');
    }
}
