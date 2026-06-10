<?php

namespace App\Livewire\Admin\Layanan;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Layanan;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $layananId;
    public $name;
    public $url;
    public $newImage;
    public $oldImage;

    public function mount(Layanan $layanan)
    {
        $this->layananId = $layanan->id;
        $this->name = $layanan->name;
        $this->url = $layanan->url;
        $this->oldImage = $layanan->image;
    }

    protected $rules = [
        'name' => 'required|max:255',
        'url' => 'required|url|max:255',
        'newImage' => 'nullable|image|max:2048', // 2MB Max
    ];

    public function save()
    {
        $this->validate();

        $layanan = Layanan::findOrFail($this->layananId);
        $path = $this->oldImage;

        if ($this->newImage) {
            if ($this->oldImage) {
                Storage::disk('public')->delete($this->oldImage);
            }
            $path = $this->newImage->store('layanan', 'public');
        }

        $layanan->update([
            'name' => $this->name,
            'url' => $this->url,
            'image' => $path,
        ]);

        return redirect()->route('admin.layanan.index')->with('message', 'Layanan berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.layanan.edit')->layout('layouts.admin');
    }
}
