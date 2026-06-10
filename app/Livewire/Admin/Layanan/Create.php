<?php

namespace App\Livewire\Admin\Layanan;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Layanan;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $url;
    public $image;

    protected $rules = [
        'name' => 'required|max:255',
        'url' => 'required|url|max:255',
        'image' => 'required|image|max:2048', // 2MB Max
    ];

    public function save()
    {
        $this->validate();

        $path = $this->image->store('layanan', 'public');

        Layanan::create([
            'name' => $this->name,
            'url' => $this->url,
            'image' => $path,
        ]);

        return redirect()->route('admin.layanan.index')->with('message', 'Layanan berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.layanan.create')->layout('layouts.admin');
    }
}
