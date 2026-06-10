<?php

namespace App\Livewire\Admin\Pages;

use Livewire\Component;
use App\Models\LibraryProfile;

class Profil extends Component
{
    public $visi;
    public $tagline;
    public $misi;
    public $functions;
    public $tasks;
    public $legal_bases;
    public $milestones;
    public $collections;

    public function mount()
    {
        $profile = LibraryProfile::first();

        if ($profile) {
            $this->visi = $profile->visi;
            $this->tagline = $profile->tagline;
            $this->misi = $this->arrayToString($profile->misi);
            $this->functions = $this->arrayToString($profile->functions);
            $this->tasks = $this->arrayToString($profile->tasks);
            $this->legal_bases = $this->arrayToString($profile->legal_bases);
            $this->milestones = $this->arrayToString($profile->milestones);
            $this->collections = $this->arrayToString($profile->collections);
        }
    }

    private function arrayToString($array)
    {
        if (empty($array)) return '';
        
        if (!is_array($array)) return (string) $array;

        return implode("\n", array_map(function ($item) {
            if (is_string($item)) return $item;
            
            // Normalize object to array
            $item = (array) $item;
            $parts = [];

            // Handle Milestones (Year: Title)
            if (isset($item['year'])) {
                $parts[] = $item['year'];
            }

            // Handle common title/item fields
            if (isset($item['title'])) $parts[] = $item['title'];
            if (isset($item['item'])) $parts[] = $item['item'];
            if (isset($item['category'])) $parts[] = "Kategori: " . $item['category'];
            if (isset($item['quantity'])) $parts[] = "Jumlah: " . $item['quantity'];

            // Handle description (strip HTML)
            if (isset($item['description'])) {
                $desc = strip_tags($item['description']);
                $desc = trim(preg_replace('/\s+/', ' ', $desc)); // Remove excessive whitespace/newlines
                if (!empty($desc)) {
                    $parts[] = $desc;
                }
            }

            if (!empty($parts)) {
                return implode(" - ", $parts);
            }

            // Fallback
            return json_encode($item, JSON_UNESCAPED_UNICODE);
        }, $array));
    }

    private function stringToArray($string)
    {
        if (empty($string)) return null;
        return array_map('trim', explode("\n", $string));
    }

    protected $rules = [
        'visi' => 'nullable|string',
        'tagline' => 'nullable|string',
        'misi' => 'nullable|string',
        'functions' => 'nullable|string',
        'tasks' => 'nullable|string',
        'legal_bases' => 'nullable|string',
        'milestones' => 'nullable|string',
        'collections' => 'nullable|string',
    ];

    public function save()
    {
        $this->validate();

        $data = [
            'visi' => $this->visi,
            'tagline' => $this->tagline,
            'misi' => $this->stringToArray($this->misi),
            'functions' => $this->stringToArray($this->functions),
            'tasks' => $this->stringToArray($this->tasks),
            'legal_bases' => $this->stringToArray($this->legal_bases),
            'milestones' => $this->stringToArray($this->milestones),
            'collections' => $this->stringToArray($this->collections),
        ];

        $profile = LibraryProfile::first();

        if ($profile) {
            $profile->update($data);
        } else {
            LibraryProfile::create($data);
        }

        session()->flash('message', 'Profil perpustakaan berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.pages.profil')->layout('layouts.admin');
    }
}
