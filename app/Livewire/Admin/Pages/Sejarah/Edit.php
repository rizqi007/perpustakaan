<?php

namespace App\Livewire\Admin\Pages\Sejarah;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SejarahPerpustakaan;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $sejarahId;
    public $year;
    public $title;
    public $description;
    public $newImage;
    public $oldImage;
    public $is_active;

    public function mount(SejarahPerpustakaan $sejarah)
    {
        $this->sejarahId = $sejarah->id;
        $this->year = $sejarah->year;
        $this->title = $sejarah->title;
        $this->description = $sejarah->description;
        $this->oldImage = $sejarah->image;
        $this->is_active = $sejarah->is_active;
    }

    protected $rules = [
        'year' => 'required|integer|min:1900|max:2100',
        'title' => 'required|max:255',
        'description' => 'required|string',
        'newImage' => 'nullable|image|max:2048', // 2MB Max
        'is_active' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        $sejarah = SejarahPerpustakaan::findOrFail($this->sejarahId);
        $path = $this->oldImage;

        if ($this->newImage) {
            if ($this->oldImage) {
                Storage::disk('public')->delete($this->oldImage);
            }
            $path = $this->newImage->store('sejarah', 'public');
        }

        $sejarah->update([
            'year' => $this->year,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $path,
            'is_active' => $this->is_active,
        ]);

        return redirect()->route('admin.pages.sejarah.index')->with('message', 'Sejarah berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.pages.sejarah.edit')->layout('layouts.admin');
    }
}
