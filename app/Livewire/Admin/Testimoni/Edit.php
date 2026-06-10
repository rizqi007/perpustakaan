<?php

namespace App\Livewire\Admin\Testimoni;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Testimoni;
use Illuminate\Support\Facades\Storage;

class Edit extends Component
{
    use WithFileUploads;

    public $testimoniId;
    public $name;
    public $institution;
    public $quote;
    public $newPhoto;
    public $oldPhoto;
    public $newVideo;
    public $oldVideo;
    public $youtube_url;
    public $is_active;

    public function mount(Testimoni $testimoni)
    {
        $this->testimoniId = $testimoni->id;
        $this->name = $testimoni->name;
        $this->institution = $testimoni->institution;
        $this->quote = $testimoni->quote;
        $this->oldPhoto = $testimoni->photo;
        $this->oldVideo = $testimoni->video;
        $this->youtube_url = $testimoni->youtube_url;
        $this->is_active = $testimoni->is_active;
    }

    protected $rules = [
        'name' => 'required|max:255',
        'institution' => 'nullable|max:255',
        'quote' => 'required|string',
        'newPhoto' => 'nullable|image|max:2048', // 2MB Max
        'newVideo' => 'nullable|file|mimetypes:video/mp4,video/avi,video/mpeg|max:10240', // 10MB Max
        'youtube_url' => 'nullable|url',
        'is_active' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        $testimoni = Testimoni::findOrFail($this->testimoniId);
        
        $photoPath = $this->oldPhoto;
        if ($this->newPhoto) {
            if ($this->oldPhoto) {
                Storage::disk('public')->delete($this->oldPhoto);
            }
            $photoPath = $this->newPhoto->store('testimoni/photos', 'public');
        }

        $videoPath = $this->oldVideo;
        if ($this->newVideo) {
             if ($this->oldVideo) {
                Storage::disk('public')->delete($this->oldVideo);
            }
            $videoPath = $this->newVideo->store('testimoni/videos', 'public');
        }

        $testimoni->update([
            'name' => $this->name,
            'institution' => $this->institution,
            'quote' => $this->quote,
            'photo' => $photoPath,
            'video' => $videoPath,
            'youtube_url' => $this->youtube_url,
            'is_active' => $this->is_active,
        ]);

        return redirect()->route('admin.testimoni.index')->with('message', 'Testimoni berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.testimoni.edit')->layout('layouts.admin');
    }
}
