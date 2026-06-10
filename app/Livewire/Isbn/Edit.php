<?php

namespace App\Livewire\Isbn;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\IsbnSubmission;
use Illuminate\Support\Facades\Auth;

class Edit extends Component
{
    use WithFileUploads;

    public IsbnSubmission $submission;

    // Instansi
    public $instansi_type;
    public $instansi_name;

    // Book info
    public $title;
    public $author;
    public $publisher;
    public $publication_year;
    public $pages;
    public $language;
    public $file; // new file upload (optional)
    public $description;

    public function mount(IsbnSubmission $submission)
    {
        // Only the owner can edit, and only when status is 'perlu_diperbaiki'
        if ($submission->user_id !== Auth::id() || !$submission->needsRevision()) {
            abort(403, 'Anda tidak memiliki akses atau pengajuan ini tidak perlu diperbaiki.');
        }

        $this->submission       = $submission;
        $this->instansi_type    = $submission->instansi_type;
        $this->instansi_name    = $submission->instansi_name;
        $this->title            = $submission->title;
        $this->author           = $submission->author;
        $this->publisher        = $submission->publisher;
        $this->publication_year = $submission->publication_year;
        $this->pages            = $submission->pages;
        $this->language         = $submission->language;
        $this->description      = $submission->description;
    }

    protected function rules()
    {
        return [
            'instansi_type'    => 'required|in:kanwil,kemenag,madrasah',
            'instansi_name'    => 'required|string|max:255',
            'title'            => 'required|max:255',
            'author'           => 'required|max:255',
            'publisher'        => 'required|max:255',
            'publication_year' => 'required|integer|digits:4',
            'pages'            => 'nullable|integer|min:1',
            'language'         => 'nullable|string|max:50',
            'file'             => 'nullable|file|max:10240|mimes:pdf,zip,rar,doc,docx',
            'description'      => 'nullable|string',
        ];
    }

    protected $messages = [
        'instansi_type.required' => 'Tipe instansi harus dipilih.',
        'instansi_name.required' => 'Nama instansi harus diisi.',
        'title.required'         => 'Judul buku harus diisi.',
        'author.required'        => 'Nama penulis harus diisi.',
        'publisher.required'     => 'Nama penerbit harus diisi.',
        'publication_year.required' => 'Tahun terbit harus diisi.',
        'publication_year.digits'   => 'Tahun terbit harus 4 digit.',
        'file.max'               => 'Ukuran file maksimal 10MB.',
        'file.mimes'             => 'Format file harus PDF, ZIP, RAR, DOC, atau DOCX.',
    ];

    public function getInstansiNameLabel(): string
    {
        return match($this->instansi_type) {
            'kanwil'   => 'Nama Kantor Wilayah',
            'kemenag'  => 'Nama Kemenag Kabupaten/Kota',
            'madrasah' => 'Nama Madrasah',
            default    => 'Nama Instansi',
        };
    }

    public function save()
    {
        $this->validate();

        $data = [
            'instansi_type'       => $this->instansi_type,
            'instansi_name'       => $this->instansi_name,
            'title'               => $this->title,
            'author'              => $this->author,
            'publisher'           => $this->publisher,
            'publication_year'    => $this->publication_year,
            'pages'               => $this->pages,
            'language'            => $this->language ?: 'Indonesia',
            'description'         => $this->description,
            // After revision, move back to verifikasi_kemenag
            'workflow_status'     => IsbnSubmission::WORKFLOW_VERIFIKASI_KEMENAG,
            'revision_notes'      => null, // clear the revision note
        ];

        // If a new file was uploaded, replace it
        if ($this->file) {
            $path = $this->file->store('isbn_submissions', 'public');
            $data['file_path']          = $path;
            $data['file_original_name'] = $this->file->getClientOriginalName();
        }

        $this->submission->update($data);

        return redirect()->route('isbn.index')->with('success', 'Pengajuan berhasil diperbaiki dan telah dikembalikan untuk diverifikasi.');
    }

    public function render()
    {
        return view('livewire.isbn.edit', [
            'instansiNameLabel' => $this->getInstansiNameLabel(),
        ])->layout('layouts.app');
    }
}
