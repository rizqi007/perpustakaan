<?php

namespace App\Livewire\Isbn;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\IsbnSubmission;
use Illuminate\Support\Facades\Auth;

class Create extends Component
{
    use WithFileUploads;

    // Instansi
    public $instansi_type = 'madrasah';
    public $instansi_name = '';

    // Book info
    public $title;
    public $author;
    public $publisher;
    public $publication_year;
    public $pages;
    public $language = 'Indonesia';
    public $file;
    public $description;

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
            'file'             => 'required|file|max:10240|mimes:pdf,zip,rar,doc,docx',
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
        'file.required'          => 'File naskah harus diunggah.',
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

        $path = $this->file->store('isbn_submissions', 'public');

        IsbnSubmission::create([
            'user_id'             => Auth::id(),
            'instansi_type'       => $this->instansi_type,
            'instansi_name'       => $this->instansi_name,
            'title'               => $this->title,
            'author'              => $this->author,
            'publisher'           => $this->publisher,
            'publication_year'    => $this->publication_year,
            'pages'               => $this->pages,
            'language'            => $this->language ?: 'Indonesia',
            'file_path'           => $path,
            'file_original_name'  => $this->file->getClientOriginalName(),
            'description'         => $this->description,
            'status'              => 'pending',
            'workflow_status'     => IsbnSubmission::WORKFLOW_DATA_DITERIMA,
        ]);

        return redirect()->route('isbn.index')->with('success', 'Pengajuan ISBN berhasil dikirim! Kami akan memproses pengajuan Anda.');
    }

    public function render()
    {
        return view('livewire.isbn.create', [
            'instansiNameLabel' => $this->getInstansiNameLabel(),
        ])->layout('layouts.app');
    }
}
