<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\BukuTamu;

class BukuTamuForm extends Component
{
    public $nama;
    public $institusi;
    public $successMessage = false;
    public $submittedName = '';
    public $anggota = null;

    protected $rules = [
        'nama' => 'required|string|max:255',
        'institusi' => 'nullable|string|max:255',
    ];

    public function updatedNama($value)
    {
        $this->anggota = \App\Models\Anggota::where('nip', $value)->first();
        if ($this->anggota) {
            $this->institusi = $this->anggota->institusi;
        }
    }

    public function submit()
    {
        $this->validate();

        $namaToSave = $this->anggota ? $this->anggota->nama : $this->nama;

        // Check if the same name has already submitted today
        $exists = BukuTamu::where('nama', $namaToSave)
            ->whereDate('created_at', \Carbon\Carbon::today())
            ->exists();

        if ($exists) {
            $this->addError('nama', 'Anda sudah mengisi buku tamu hari ini.');
            return;
        }

        BukuTamu::create([
            'nama' => $namaToSave,
            'institusi' => $this->institusi,
        ]);

        $this->submittedName = $namaToSave;
        $this->reset(['nama', 'institusi', 'anggota']);
        $this->successMessage = true;

        $this->dispatch('visitorAdded'); // For any listenings
    }

    public function resetForm()
    {
        $this->successMessage = false;
        $this->reset(['nama', 'institusi', 'anggota']);
    }

    public function render()
    {
        return view('livewire.buku-tamu-form')->layout('layouts.public', ['title' => 'Buku Tamu']);
    }
}
