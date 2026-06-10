<?php

namespace App\Livewire\Admin\Banners;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Banner;

class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $description;
    public $image;
    public $is_active = true;

    protected $rules = [
        'title' => 'required|max:255',
        'description' => 'nullable|string',
        'image' => 'required|image|max:2048', // 2MB Max
        'is_active' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        $path = $this->image->store('banners', 'public');

        Banner::create([
            'title' => $this->title,
            'description' => $this->description,
            'image' => $path,
            'is_active' => $this->is_active,
        ]);

        return redirect()->route('admin.banners.index')->with('message', 'Banner berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.banners.create')->layout('layouts.admin');
    }
}
