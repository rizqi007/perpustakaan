<?php

namespace App\Livewire\Admin\Banners;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination;

    public function delete($id)
    {
        $banner = Banner::findOrFail($id);
        
        if ($banner->image) {
            Storage::disk('public')->delete($banner->image);
        }
        
        $banner->delete();
        
        session()->flash('message', 'Banner berhasil dihapus.');
    }

    public function toggleActive($id)
    {
        $banner = Banner::findOrFail($id);
        $banner->is_active = !$banner->is_active;
        $banner->save();
    }

    public function render()
    {
        return view('livewire.admin.banners.index', [
            'banners' => Banner::latest()->paginate(10)
        ])->layout('layouts.admin');
    }
}
