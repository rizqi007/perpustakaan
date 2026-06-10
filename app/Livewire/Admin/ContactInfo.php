<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\ContactInfo as ContactInfoModel;

class ContactInfo extends Component
{
    public $address;
    public $phone;
    public $email;
    public $monday_thursday;
    public $friday;
    public $saturday;
    public $sunday;
    public $map_embed_url;
    public $is_active;

    public function mount()
    {
        $contact = ContactInfoModel::first();

        if ($contact) {
            $this->address = $contact->address;
            $this->phone = $contact->phone;
            $this->email = $contact->email;
            $this->monday_thursday = $contact->monday_thursday;
            $this->friday = $contact->friday;
            $this->saturday = $contact->saturday;
            $this->sunday = $contact->sunday;
            $this->map_embed_url = $contact->map_embed_url;
            $this->is_active = $contact->is_active;
        } else {
            $this->is_active = true;
        }
    }

    protected $rules = [
        'address' => 'required|string',
        'phone' => 'nullable|string',
        'email' => 'nullable|email',
        'monday_thursday' => 'nullable|string',
        'friday' => 'nullable|string',
        'saturday' => 'nullable|string',
        'sunday' => 'nullable|string',
        'map_embed_url' => 'nullable|string',
        'is_active' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        $data = [
            'address' => $this->address,
            'phone' => $this->phone,
            'email' => $this->email,
            'monday_thursday' => $this->monday_thursday,
            'friday' => $this->friday,
            'saturday' => $this->saturday,
            'sunday' => $this->sunday,
            'map_embed_url' => $this->map_embed_url,
            'is_active' => $this->is_active,
        ];

        $contact = ContactInfoModel::first();

        if ($contact) {
            $contact->update($data);
        } else {
            ContactInfoModel::create($data);
        }

        session()->flash('message', 'Informasi kontak berhasil diperbarui.');
    }

    public function render()
    {
        return view('livewire.admin.contact-info')->layout('layouts.admin');
    }
}
