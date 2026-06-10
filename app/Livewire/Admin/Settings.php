<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
// use App\Models\Setting; // Assuming we would use a Setting model, but for now strict implementation might be file based/env or simple key-value table. 
// Since no Setting model was mentioned in previous steps, I'll check if it exists or use a simple JSON file or just assume we need to create one.
// There is no Setting model in the task summary. 
// I will create a simple 'Setting' model if it doesn't exist, or just use a JSON file for simplicity if preferred?
// No, standard Laravel approach is a settings table.
// However, I don't recall creating a Setting model.
// I'll check file list.

use App\Models\Setting; // Potential import
use Illuminate\Support\Facades\Storage;

class Settings extends Component
{
    use WithFileUploads;

    public $site_name;
    public $site_description;
    public $logo;
    public $favicon;
    public $existingLogo;
    public $existingFavicon;
    public $maintenance_mode;

    public function mount()
    {
        // Check if we can store settings.
        // If no model, maybe just use a config file? No, needs to be dynamic.
        // Let's assume we use a 'settings' table or similar. The user didn't explicitly ask for a specific implementation.
        // I'll check if Setting model exists in next step.
        // For now, I will draft this assuming a key-value store or similar.
        
        // As I cannot verify model existence inside this tool call easily (I could have checked before), 
        // I will implement a basic version that simulates settings or uses a simple json file in storage if model missing.
        // BETTER: I will create the Migration and Model for Settings as part of this step (via run_command if I could).
        // Since I am in 'write_to_file', I can't run shell.
        
        // I will write this file assuming App\Models\Setting exists (key, value).
        // I'll create the model/migration in valid tool calls next.
        
        $settings = \App\Models\Setting::all()->pluck('value', 'key');

        $this->site_name = $settings['site_name'] ?? config('app.name');
        $this->site_description = $settings['site_description'] ?? '';
        $this->existingLogo = $settings['site_logo'] ?? null;
        $this->existingFavicon = $settings['site_favicon'] ?? null;
        $this->maintenance_mode = ($settings['maintenance_mode'] ?? '0') === '1';
    }

    public function save()
    {
        $this->validate([
            'site_name' => 'required|string|max:255',
            'site_description' => 'nullable|string|max:500',
            'logo' => 'nullable|image|max:1024',
            'favicon' => 'nullable|image|max:512',
            'maintenance_mode' => 'boolean',
        ]);

        if ($this->logo) {
             if ($this->existingLogo) {
                Storage::disk('public')->delete($this->existingLogo);
            }
            $logoPath = $this->logo->store('settings', 'public');
            \App\Models\Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $logoPath]);
            $this->existingLogo = $logoPath;
        }

        if ($this->favicon) {
             if ($this->existingFavicon) {
                Storage::disk('public')->delete($this->existingFavicon);
            }
            $faviconPath = $this->favicon->store('settings', 'public');
            \App\Models\Setting::updateOrCreate(['key' => 'site_favicon'], ['value' => $faviconPath]);
            $this->existingFavicon = $faviconPath;
        }

        \App\Models\Setting::updateOrCreate(['key' => 'site_name'], ['value' => $this->site_name]);
        \App\Models\Setting::updateOrCreate(['key' => 'site_description'], ['value' => $this->site_description]);
        \App\Models\Setting::updateOrCreate(['key' => 'maintenance_mode'], ['value' => $this->maintenance_mode ? '1' : '0']);

        \Illuminate\Support\Facades\Cache::forget('site_settings');

        session()->flash('message', 'Pengaturan berhasil disimpan.');
        $this->reset(['logo', 'favicon']);
    }

    public function render()
    {
        return view('livewire.admin.settings')->layout('layouts.admin');
    }
}
