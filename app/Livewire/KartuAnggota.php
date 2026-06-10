<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Anggota;
use App\Models\CardTemplate;

class KartuAnggota extends Component
{
    public $nip = '';
    public $anggota = null;
    public $notFound = false;

    protected $rules = [
        'nip' => 'required|string',
    ];

    protected $messages = [
        'nip.required' => 'NIP / ID Anggota wajib diisi.',
        'nip.string' => 'NIP / ID Anggota harus berupa teks.',
    ];

    public function cari()
    {
        $this->validate();
        $this->notFound = false;

        $this->anggota = Anggota::where('nip', $this->nip)
            ->where('status', 'approved')
            ->first();

        if (!$this->anggota) {
            $this->notFound = true;
        }
    }

    public function resetCari()
    {
        $this->reset(['nip', 'anggota', 'notFound']);
    }

    public function render()
    {
        $template = CardTemplate::getActive();

        return view('livewire.kartu-anggota', [
            'template' => $template,
        ])->layout('layouts.public', ['title' => 'Kartu Anggota']);
    }
}
