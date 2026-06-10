<?php

namespace App\Livewire\Katalog;

use Livewire\Component;
use App\Models\KatalogBuku;

class Show extends Component
{
    public KatalogBuku $book;

    public function mount(KatalogBuku $book)
    {
        $this->book = $book;
    }

    public function render()
    {
        return view('livewire.katalog.show', [
            'book' => $this->book,
        ])->layout('layouts.public', ['title' => $this->book->judul_penanggung_jawab ?? 'Detail Buku']);
    }
}
