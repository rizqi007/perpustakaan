<?php

namespace App\Livewire\Admin\Berita;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Berita;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $beritaId;
    public $title;
    public $content;
    public $newImage;
    public $oldImage;
    public $is_published;
    public $published_at;

    public function mount(Berita $berita)
    {
        $this->beritaId = $berita->id;
        $this->title = $berita->title;
        $this->content = $berita->content;
        $this->oldImage = $berita->image;
        $this->is_published = $berita->is_published;
        $this->published_at = $berita->published_at ? $berita->published_at->format('Y-m-d') : null;
    }

    protected $rules = [
        'title' => 'required|max:255',
        'content' => 'required|string',
        'newImage' => 'nullable|image|max:2048', // 2MB Max
        'is_published' => 'boolean',
        'published_at' => 'nullable|date',
    ];

    public function save()
    {
        $this->validate();

        $berita = Berita::findOrFail($this->beritaId);
        $path = $this->oldImage;

        if ($this->newImage) {
            if ($this->oldImage) {
                Storage::disk('public')->delete($this->oldImage);
            }
            $path = $this->newImage->store('berita', 'public');
        }

        // Only update slug if title changed, or keep it same? usually better to keep slug stable or update it? 
        // Let's update it if title changes significantly or just keep simple.
        // Actually, updating slug might break external links. Let's keep slug unless explicitly requested.
        // But for simplicity, we can update it.
        $slug = Str::slug($this->title);
        if ($slug !== $berita->slug) {
             $count = Berita::where('slug', $slug)->where('id', '!=', $this->beritaId)->count();
            if ($count > 0) {
                $slug = $slug . '-' . time();
            }
        } else {
            $slug = $berita->slug;
        }

        $berita->update([
            'title' => $this->title,
            'slug' => $slug,
            'content' => $this->content,
            'image' => $path,
            'is_published' => $this->is_published,
            'published_at' => $this->published_at,
        ]);

        return redirect()->route('admin.berita.index')->with('message', 'Berita berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.berita.edit')->layout('layouts.admin');
    }
}
