<?php

namespace App\Livewire\Admin\Pages\Sejarah;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\SejarahPerpustakaan;

class Create extends Component
{
    use WithFileUploads;

    public $year;
    public $title;
    public $description;
    public $image;
    public $is_active = true;

    protected $rules = [
        'year' => 'required|integer|min:1900|max:2100',
        'title' => 'required|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|max:2048', // 2MB Max
        'is_active' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        $path = null;
        if ($this->image) {
            $path = $this->image->store('sejarah', 'public');
        }

        SejarahPerpustakaan::create([
            'year' => $this->year,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $path,
            'is_active' => $this->is_active,
        ]);

        return redirect()->route('admin.pages.sejarah.index')->with('message', 'Sejarah berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.pages.sejarah.create')->layout('layouts.admin');
    }
}
