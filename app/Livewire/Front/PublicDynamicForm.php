<?php

namespace App\Livewire\Front;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Form;
use App\Models\FormSubmission;

class PublicDynamicForm extends Component
{
    use WithFileUploads;

    public $slug;
    public $form;
    public $data = [];
    public $successMessage = '';
    public $showForm = true;
    public $isQuotaFull = false;
    public $isDateValid = true;
    public $dateMessage = '';
    
    // Captcha
    public $captchaA;
    public $captchaB;
    public $captchaInput;

    public function mount($slug = null)
    {
        $this->generateCaptcha();

        if ($slug) {
            // Normalize slug: URL may come as short slug (e.g. "bibliobattle")
            // or full DB slug (e.g. "daftar-hadir-bibliobattle") or "daftar-hadir-pengunjung"
            // Always resolve to the full internal DB slug.
            $dbSlug = $slug;
            if (!str_starts_with($slug, 'daftar-hadir-')) {
                // Try full slug first (e.g. from /formulir/{slug} route)
                $exists = Form::where('slug', $slug)->exists();
                if (!$exists) {
                    // Must be short slug from /daftar-hadir/{slug} — add prefix
                    $dbSlug = 'daftar-hadir-' . $slug;
                }
            }

            // Store the full DB slug for internal use (Kegiatan check, etc.)
            $this->slug = $dbSlug;

            // Auto-bootstrap default visitor form if missing
            $exists = Form::where('slug', $dbSlug)->exists();
            if (!$exists && $dbSlug === 'daftar-hadir-pengunjung') {
                Form::create([
                    'title'       => 'Daftar Hadir Pengunjung',
                    'slug'        => 'daftar-hadir-pengunjung',
                    'description' => 'Formulir daftar hadir untuk pengunjung perpustakaan.',
                    'is_active'   => true,
                    'fields'      => [
                        ['type' => 'text', 'label' => 'Nama',             'required' => true, 'helper_text' => 'Nama lengkap Anda'],
                        ['type' => 'text', 'label' => 'Instansi',         'required' => true, 'helper_text' => 'Instansi atau asal Anda'],
                        ['type' => 'text', 'label' => 'Nomor Handphone',  'required' => true, 'helper_text' => 'Nomor WhatsApp / HP aktif'],
                    ],
                ]);
            }

            $form = Form::where('slug', $dbSlug)->first();
            if ($form && !$form->is_active && $dbSlug === 'daftar-hadir-pengunjung') {
                $form->update(['is_active' => true]);
            }

            $this->form = Form::where('slug', $dbSlug)->where('is_active', true)->first();
            if ($this->form) {
                // Initialize data array
                foreach ($this->form->fields as $field) {
                    $this->data[$field['label']] = '';
                }

                // Set default values for date fields
                foreach ($this->form->fields as $field) {
                    if ($field['type'] === 'date') {
                        $this->data[$field['label']] = date('Y-m-d');
                    }
                }

                // Always auto-fill "Kegiatan" with the form title (hidden from user)
                // This applies to all daftar-hadir forms
                if (str_starts_with($dbSlug, 'daftar-hadir-')) {
                    $this->data['Kegiatan'] = $this->form->title;
                }
            }
        }
    }


    public function generateCaptcha()
    {
        $this->captchaA = rand(1, 10);
        $this->captchaB = rand(1, 10);
        $this->captchaInput = '';
    }

    public function toggleForm()
    {
        $this->showForm = true;
        $this->successMessage = '';
        $this->generateCaptcha();
    }

    public function submit()
    {
        if (!$this->form) return;

        // Captcha validation
        if ((int)$this->captchaInput !== ($this->captchaA + $this->captchaB)) {
            $this->addError('captchaInput', 'Jawaban perhitungan salah. Silakan coba lagi.');
            $this->generateCaptcha();
            return;
        }

        $rules = [];
        $messages = [];

        foreach ($this->form->fields as $field) {
            // Skip "Kegiatan" field for daftar-hadir forms — auto-filled, no validation needed
            if (str_starts_with($this->slug ?? '', 'daftar-hadir-') && strtolower($field['label']) === 'kegiatan') {
                continue;
            }

            $key = 'data.' . $field['label'];
            $rule = [];
            
            if ($field['required']) {
                $rule[] = 'required';
                $messages[$key . '.required'] = $field['label'] . ' wajib diisi.';
            }
            if ($field['type'] === 'email') $rule[] = 'email';
            if ($field['type'] === 'number') $rule[] = 'numeric';
            if ($field['type'] === 'file') $rule[] = 'file|max:10240';

            if (!empty($rule)) {
                $rules[$key] = implode('|', $rule);
            }
        }

        $this->validate($rules, $messages);

        // Build submission data directly from all user input
        $submissionData = [];
        $bookingDate = null;
        
        foreach ($this->data as $label => $value) {
            if ($value instanceof \Illuminate\Http\UploadedFile) {
                $path = $value->store('form_submissions', 'public');
                $submissionData[$label] = $path;
            } else {
                $submissionData[$label] = $value;
            }
        }

        // Find booking date from any date field
        foreach ($this->form->fields as $field) {
            if ($field['type'] === 'date' && !$bookingDate && !empty($this->data[$field['label']])) {
                $bookingDate = $this->data[$field['label']];
            }
        }

        FormSubmission::create([
            'form_id'      => $this->form->id,
            'user_id'      => null, // Guest
            'data'         => $submissionData,
            'booking_date' => $bookingDate ?? date('Y-m-d'), // Auto-assign today if not set
            'status'       => 'approved', // Auto approve since it's just a guest book
        ]);

        $this->successMessage = 'Terima kasih telah mengisi daftar hadir.';
        $this->dispatch('toast', type: 'success', message: 'Terkirim!');
        $this->showForm = false;
        
        // Reset form data, but keep date as today and re-inject Kegiatan
        foreach ($this->form->fields as $field) {
            $this->data[$field['label']] = $field['type'] === 'date' ? date('Y-m-d') : '';
        }
        // Re-inject Kegiatan auto-value after reset
        if (str_starts_with($this->slug ?? '', 'daftar-hadir-')) {
            $this->data['Kegiatan'] = $this->form->title;
        }
    }

    public function render()
    {
        return view('livewire.front.public-dynamic-form')->layout('layouts.public');
    }
}
