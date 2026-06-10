<?php

namespace App\Livewire\Admin\Banners;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $bannerId;
    public $title;
    public $description;
    public $newImage;
    public $oldImage;
    public $is_active;

    public function mount(Banner $banner)
    {
        $this->bannerId = $banner->id;
        $this->title = $banner->title;
        $this->description = $banner->description;
        $this->oldImage = $banner->image;
        $this->is_active = $banner->is_active;
    }

    protected $rules = [
        'title' => 'required|max:255',
        'description' => 'nullable|string',
        'newImage' => 'nullable|image|max:2048', // 2MB Max
        'is_active' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        $banner = Banner::findOrFail($this->bannerId);
        $path = $this->oldImage;

        if ($this->newImage) {
            if ($this->oldImage) {
                Storage::disk('public')->delete($this->oldImage);
            }
            $path = $this->newImage->store('banners', 'public');
        }

        $banner->update([
            'title' => $this->title,
            'description' => $this->description,
            'image' => $path,
            'is_active' => $this->is_active,
        ]);

        return redirect()->route('admin.banners.index')->with('message', 'Banner berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.banners.edit')->layout('layouts.admin');
    }
}
