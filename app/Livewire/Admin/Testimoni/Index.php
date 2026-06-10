<?php

namespace App\Livewire\Admin\Testimoni;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Testimoni;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        
        if ($testimoni->photo) {
            Storage::disk('public')->delete($testimoni->photo);
        }
        if ($testimoni->video) {
            Storage::disk('public')->delete($testimoni->video);
        }
        
        $testimoni->delete();
        
        session()->flash('message', 'Testimoni berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $testimoni = Testimoni::findOrFail($id);
        $testimoni->is_active = !$testimoni->is_active;
        $testimoni->save();
    }

    public function render()
    {
        return view('livewire.admin.testimoni.index', [
            'testimonis' => Testimoni::latest()->paginate(10)
        ])->layout('layouts.admin');
    }
}
