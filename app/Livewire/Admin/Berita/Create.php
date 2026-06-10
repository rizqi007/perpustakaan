<?php

namespace App\Livewire\Admin\Berita;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Berita;
use Illuminate\Support\Str;

class Create extends Component
{
    use WithFileUploads;

    public $title;
    public $content;
    public $image;
    public $is_published = true; // Default to published
    public $published_at;

    protected $rules = [
        'title' => 'required|max:255',
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048', // 2MB Max
        'is_published' => 'boolean',
        'published_at' => 'nullable|date',
    ];

    public function mount()
    {
        $this->published_at = now()->format('Y-m-d');
    }

    public function save()
    {
        $this->validate();

        $path = null;
        if ($this->image) {
            $path = $this->image->store('berita', 'public');
        }

        $slug = Str::slug($this->title);
        // Ensure unique slug
        $count = Berita::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . time();
        }

        Berita::create([
            'title' => $this->title,
            'slug' => $slug,
            'content' => $this->content,
            'image' => $path,
            'is_published' => $this->is_published,
            'published_at' => $this->published_at,
        ]);

        return redirect()->route('admin.berita.index')->with('message', 'Berita berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.berita.create')->layout('layouts.admin');
    }
}
