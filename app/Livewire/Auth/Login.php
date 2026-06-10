<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Login extends Component
{
    public string $email = '';
    public string $password = '';
    public string $captcha_input = '';

    public function mount()
    {
        $this->generateCaptcha();
    }

    public function generateCaptcha()
    {
        $characters = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $code = substr(str_shuffle($characters), 0, 3);
        session()->put('captcha_code', $code);
    }

    public function getCaptchaCode(): string
    {
        return session('captcha_code', '');
    }

    public function refreshCaptcha()
    {
        $this->generateCaptcha();
        $this->captcha_input = '';
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required',
            'captcha_input' => 'required',
        ], [
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'captcha_input.required' => 'Captcha wajib diisi.',
        ]);

        if (strtoupper(trim($this->captcha_input)) !== strtoupper(session('captcha_code', ''))) {
            $this->generateCaptcha();
            $this->captcha_input = '';
            $this->addError('captcha_input', 'Captcha tidak sesuai.');
            $this->dispatch('toast', type: 'error', message: 'Captcha tidak sesuai.');
            return;
        }

        if (!Auth::attempt(['email' => $this->email, 'password' => $this->password])) {
            $this->generateCaptcha();
            $this->captcha_input = '';
            $this->addError('email', 'Email atau password salah.');
            $this->dispatch('toast', type: 'error', message: 'Email atau password salah.');
            return;
        }

        $user = Auth::user();
        if (!$user->is_validated) {
            Auth::logout();
            $this->generateCaptcha();
            $this->captcha_input = '';
            session()->flash('warning_validation', 'Akun Anda belum divalidasi oleh Admin. Silakan tunggu hingga proses verifikasi selesai.');
            $this->addError('email', 'Akun Anda belum divalidasi oleh Admin.');
            return;
        }

        session()->regenerate();

        $this->redirect(session()->pull('url.intended', route('landing')), navigate: false);
    }

    public function render()
    {
        return view('livewire.auth.login')->layout('layouts.public');
    }
}
