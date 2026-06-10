<?php

namespace App\Livewire\Katalog;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KatalogBuku;

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
        $books = KatalogBuku::query()
            ->when($this->search, function ($q) {
                $q->where('judul_penanggung_jawab', 'like', '%' . $this->search . '%')
                  ->orWhere('identifikasi', 'like', '%' . $this->search . '%')
                  ->orWhere('subjek', 'like', '%' . $this->search . '%')
                  ->orWhere('klasifikasi', 'like', '%' . $this->search . '%')
                  ->orWhere('publikasi', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(12);

        return view('livewire.katalog.index', [
            'books' => $books,
        ])->layout('layouts.public', ['title' => 'Katalog Buku Ber-ISBN']);
    }
}
