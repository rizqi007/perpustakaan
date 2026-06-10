<?php

namespace App\Livewire\Admin\Berita;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Berita;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;
    
    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $berita = Berita::findOrFail($id);
        
        if ($berita->image) {
            Storage::disk('public')->delete($berita->image);
        }
        
        $berita->delete();
        
        session()->flash('message', 'Berita berhasil dihapus.');
    }

    public function render()
    {
        $beritas = Berita::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('content', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.berita.index', [
            'beritas' => $beritas
        ])->layout('layouts.admin');
    }
}
