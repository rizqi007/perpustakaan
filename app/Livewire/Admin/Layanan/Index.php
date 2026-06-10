<?php

namespace App\Livewire\Admin\Layanan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Layanan;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $layanan = Layanan::findOrFail($id);
        
        if ($layanan->image) {
            Storage::disk('public')->delete($layanan->image);
        }
        
        $layanan->delete();
        
        session()->flash('message', 'Layanan berhasil dihapus.');
    }

    public function render()
    {
        return view('livewire.admin.layanan.index', [
            'layanans' => Layanan::latest()->paginate(10)
        ])->layout('layouts.admin');
    }
}
