<?php

namespace App\Livewire\Admin\Pages\Sejarah;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\SejarahPerpustakaan;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $sejarah = SejarahPerpustakaan::findOrFail($id);
        
        if ($sejarah->image) {
            Storage::disk('public')->delete($sejarah->image);
        }
        
        $sejarah->delete();
        
        session()->flash('message', 'Sejarah berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $sejarah = SejarahPerpustakaan::findOrFail($id);
        $sejarah->is_active = !$sejarah->is_active;
        $sejarah->save();
    }

    public function render()
    {
        return view('livewire.admin.pages.sejarah.index', [
            'sejarahs' => SejarahPerpustakaan::ordered()->paginate(10)
        ])->layout('layouts.admin');
    }
}
