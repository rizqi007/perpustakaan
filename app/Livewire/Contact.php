<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\ContactInfo;

class Contact extends Component
{
    public $name;
    public $email;
    public $phone;
    public $subject;
    public $message;
    public $captcha;

    protected $rules = [
        'name' => 'required|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|max:20',
        'subject' => 'required|max:255',
        'message' => 'required|min:10',
        'captcha' => 'required|captcha',
    ];

    protected $messages = [
        'captcha.captcha' => 'Kode keamanan salah, silakan coba lagi.',
        'captcha.required' => 'Kode keamanan wajib diisi.',
    ];

    public function updated($propertyName)
    {
        if ($propertyName === 'captcha') {
            return;
        }
        $this->validateOnly($propertyName);
    }

    public function submit()
    {
        $this->validate();

        // Create Contact Message
        \App\Models\ContactMessage::create([
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'subject' => $this->subject,
            'message' => $this->message,
            'ip_address' => request()->ip(),
        ]);

        session()->flash('success', 'Pesan Anda berhasil dikirim! Kami akan merespons dalam 24 jam.');
        $this->dispatch('toast', type: 'success', message: 'Pesan Anda berhasil dikirim! Kami akan merespons dalam 24 jam.');

        $this->reset();
    }

    public function render()
    {
        return view('livewire.contact', [
            'contactInfo' => ContactInfo::getActive()
        ])->layout('layouts.public');
    }
}
