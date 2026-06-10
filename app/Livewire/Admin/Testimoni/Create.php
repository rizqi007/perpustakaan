<?php

namespace App\Livewire\Admin\Testimoni;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Testimoni;

class Create extends Component
{
    use WithFileUploads;

    public $name;
    public $institution;
    public $quote;
    public $photo;
    public $video;
    public $youtube_url;
    public $is_active = true;

    protected $rules = [
        'name' => 'required|max:255',
        'institution' => 'nullable|max:255',
        'quote' => 'required|string',
        'photo' => 'nullable|image|max:2048', // 2MB Max
        'video' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg|max:10240', // 10MB Max
        'youtube_url' => 'nullable|url',
        'is_active' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        $photoPath = null;
        if ($this->photo) {
            $photoPath = $this->photo->store('testimoni/photos', 'public');
        }

        $videoPath = null;
        if ($this->video) {
            $videoPath = $this->video->store('testimoni/videos', 'public');
        }

        Testimoni::create([
            'name' => $this->name,
            'institution' => $this->institution,
            'quote' => $this->quote,
            'photo' => $photoPath,
            'video' => $videoPath,
            'youtube_url' => $this->youtube_url,
            'is_active' => $this->is_active,
        ]);

        return redirect()->route('admin.testimoni.index')->with('message', 'Testimoni berhasil ditambahkan.');
    }

    public function render()
    {
        return view('livewire.admin.testimoni.create')->layout('layouts.admin');
    }
}
