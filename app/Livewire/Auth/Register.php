<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Register extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $captcha_input = '';
    public string $satuan_kerja = '';
    public bool $is_manual = false;
    public string $custom_satuan_kerja = '';
    public string $no_hp = '';
    public $surat_tugas = null;

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

    public function register()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|string|max:20|regex:/^[0-9+\-\s]+$/',
            'surat_tugas' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'password' => [
                'required',
                'min:6',
                'confirmed',
                function ($attribute, $value, $fail) {
                    // Check uppercase & lowercase
                    if (!preg_match('/[a-z]/', $value) || !preg_match('/[A-Z]/', $value)) {
                        $fail('Password harus mengandung perpaduan huruf besar dan kecil (A-Z, a-z).');
                    }
                    // Check symbol
                    if (!preg_match('/[^A-Za-z0-9]/', $value)) {
                        $fail('Password harus mengandung setidaknya satu simbol atau karakter unik (misal: !, @, #, $, dll).');
                    }
                    // Check sequential numbers
                    $len = strlen($value);
                    for ($i = 0; $i < $len - 2; $i++) {
                        $c1 = ord($value[$i]);
                        $c2 = ord($value[$i + 1]);
                        $c3 = ord($value[$i + 2]);
                        
                        if ($c1 >= 48 && $c1 <= 57 && $c2 >= 48 && $c2 <= 57 && $c3 >= 48 && $c3 <= 57) {
                            if (($c2 === $c1 + 1 && $c3 === $c2 + 1) || ($c2 === $c1 - 1 && $c3 === $c2 - 1)) {
                                $fail('Password tidak boleh mengandung angka berurutan (seperti 123 atau 321).');
                                break;
                            }
                        }
                    }
                }
            ],
            'captcha_input' => 'required',
            'satuan_kerja' => 'required_unless:is_manual,true|string|max:255',
            'custom_satuan_kerja' => 'required_if:is_manual,true|string|max:255',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.required' => 'Nomor HP wajib diisi.',
            'no_hp.max' => 'Nomor HP maksimal 20 karakter.',
            'no_hp.regex' => 'Format nomor HP tidak valid.',
            'surat_tugas.required' => 'Surat tugas wajib diunggah.',
            'surat_tugas.file' => 'Surat tugas harus berupa file.',
            'surat_tugas.mimes' => 'Format surat tugas harus PDF, JPG, JPEG, atau PNG.',
            'surat_tugas.max' => 'Ukuran surat tugas maksimal 2MB.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 6 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'captcha_input.required' => 'Captcha wajib diisi.',
            'satuan_kerja.required_unless' => 'Satuan kerja wajib diisi.',
            'custom_satuan_kerja.required_if' => 'Nama satuan kerja wajib diisi secara manual.',
        ]);

        if (strtoupper(trim($this->captcha_input)) !== strtoupper(session('captcha_code', ''))) {
            $this->generateCaptcha();
            $this->captcha_input = '';
            $this->addError('captcha_input', 'Captcha tidak sesuai.');
            $this->dispatch('toast', type: 'error', message: 'Captcha tidak sesuai.');
            return;
        }

        $finalSatuanKerja = $this->is_manual ? $this->custom_satuan_kerja : $this->satuan_kerja;
        $suratTugasPath = $this->surat_tugas->store('surat_tugas', 'public');

        // Note: User model has 'password' => 'hashed' cast, so do NOT Hash::make() here
        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'satuan_kerja' => $finalSatuanKerja,
            'is_validated' => false,
            'no_hp' => $this->no_hp,
            'surat_tugas' => $suratTugasPath,
        ]);

        session()->flash('success_register', 'Pendaftaran berhasil! Akun Anda telah dibuat dan sedang menunggu validasi oleh Admin sebelum dapat digunakan.');

        $this->redirect(route('login'), navigate: false);
    }

    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.public');
    }
}
