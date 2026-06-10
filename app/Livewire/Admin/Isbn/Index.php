<?php

namespace App\Livewire\Admin\Isbn;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\IsbnSubmission;
use App\Models\KatalogBuku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Index extends Component
{
    use WithPagination, WithFileUploads;

    public $search = '';
    public $statusFilter = '';

    // Workflow modal
    public $showWorkflowModal = false;
    public $selectedSubmissionId = null;
    public $newWorkflowStatus = '';
    public $revisionNotes = '';
    public $isbnNumber = '';
    
    // Katalog Buku fields
    public $bookTitle = '';
    public $coverFile = null;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function openWorkflowModal($id)
    {
        $submission = IsbnSubmission::findOrFail($id);
        $this->selectedSubmissionId = $id;
        $this->newWorkflowStatus    = $submission->workflow_status;
        $this->revisionNotes        = $submission->revision_notes ?? '';
        $this->isbnNumber           = $submission->isbn_number ?? '';
        $this->bookTitle            = trim("{$submission->title} / {$submission->author}", " /");
        $this->coverFile            = null;
        $this->showWorkflowModal    = true;
    }

    public function saveWorkflow()
    {
        $rules = [
            'newWorkflowStatus' => 'required|in:data_diterima,verifikasi_kemenag,perlu_diperbaiki,proses_pengajuan,verifikasi_perpusnas,isbn_terbit,penyerahan_buku,selesai',
        ];

        if ($this->newWorkflowStatus === 'perlu_diperbaiki') {
            $rules['revisionNotes'] = 'required|min:10';
        }

        if (in_array($this->newWorkflowStatus, ['isbn_terbit', 'penyerahan_buku', 'selesai'])) {
            $rules['isbnNumber'] = 'required|string|max:30';
        }

        if (in_array($this->newWorkflowStatus, ['isbn_terbit', 'penyerahan_buku', 'selesai'])) {
            $rules['bookTitle'] = 'required|string|max:255';
            $rules['coverFile'] = 'nullable|image|max:2048'; // Max 2MB
        }

        $this->validate($rules, [
            'newWorkflowStatus.required' => 'Status proses harus dipilih.',
            'revisionNotes.required'     => 'Catatan perbaikan harus diisi saat status "Perlu Diperbaiki".',
            'revisionNotes.min'          => 'Catatan perbaikan minimal 10 karakter.',
            'isbnNumber.required'        => 'Nomor ISBN harus diisi saat status "ISBN Terbit".',
            'bookTitle.required'         => 'Judul Buku harus diisi.',
            'coverFile.image'            => 'File cover harus berupa gambar.',
            'coverFile.max'              => 'Ukuran file cover maksimal 2MB.',
        ]);

        $submission = IsbnSubmission::findOrFail($this->selectedSubmissionId);

        $data = [
            'workflow_status'     => $this->newWorkflowStatus,
            'workflow_updated_by' => Auth::id(),
            'workflow_updated_at' => now(),
        ];

        // Map workflow status to legacy status
        $data['status'] = match($this->newWorkflowStatus) {
            'selesai', 'penyerahan_buku', 'isbn_terbit', 'verifikasi_perpusnas', 'proses_pengajuan' => 'approved',
            'perlu_diperbaiki' => 'rejected',
            default => 'pending',
        };

        if ($this->newWorkflowStatus === 'perlu_diperbaiki') {
            $data['revision_notes'] = $this->revisionNotes;
        } else {
            $data['revision_notes'] = null; // Clear notes when moving forward
        }

        if (in_array($this->newWorkflowStatus, ['isbn_terbit', 'penyerahan_buku', 'selesai'])) {
            $data['isbn_number'] = $this->isbnNumber;
        }

        if (in_array($this->newWorkflowStatus, ['approved', 'selesai', 'isbn_terbit', 'penyerahan_buku'])) {
            $data['reviewed_by'] = Auth::id();
            $data['reviewed_at'] = now();
        }

        $submission->update($data);

        // Handle Katalog Buku creation if published/finished
        if (in_array($this->newWorkflowStatus, ['isbn_terbit', 'penyerahan_buku', 'selesai'])) {
            $coverPath = null;
            if ($this->coverFile) {
                $coverPath = $this->coverFile->store('katalog_covers', 'public');
            } else {
                // Check if already has a KatalogBuku record to keep existing cover
                $existing = KatalogBuku::where('isbn_submission_id', $submission->id)->first();
                if ($existing) {
                    $coverPath = $existing->cover;
                }
            }

            KatalogBuku::updateOrCreate(
                ['isbn_submission_id' => $submission->id],
                [
                    'judul_penanggung_jawab' => $this->bookTitle,
                    'identifikasi'           => $this->isbnNumber ? "ISBN {$this->isbnNumber}" : ($submission->isbn_number ? "ISBN {$submission->isbn_number}" : ''),
                    'cover'                  => $coverPath,
                    'publikasi'              => $submission->publisher ? "{$submission->publisher}, {$submission->publication_year}" : (string)$submission->publication_year,
                    'deskripsi_fisik'        => $submission->pages ? "{$submission->pages} hlm." : '',
                    'sinopsis'               => $submission->description ?? '',
                ]
            );
        }

        $this->closeModal();
        session()->flash('message', 'Status proses pengajuan ISBN berhasil diperbarui.');
    }

    public function closeModal()
    {
        $this->showWorkflowModal    = false;
        $this->selectedSubmissionId = null;
        $this->newWorkflowStatus    = '';
        $this->revisionNotes        = '';
        $this->isbnNumber           = '';
        $this->bookTitle            = '';
        $this->coverFile            = null;
    }

    public function download($id)
    {
        $submission = IsbnSubmission::findOrFail($id);

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        if ($disk->exists($submission->file_path)) {
            return $disk->download($submission->file_path, $submission->file_original_name);
        }

        session()->flash('error', 'File tidak ditemukan.');
    }

    public function render()
    {
        $submissions = IsbnSubmission::query()
            ->with('user')
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('author', 'like', '%' . $this->search . '%')
                      ->orWhere('instansi_name', 'like', '%' . $this->search . '%')
                      ->orWhereHas('user', function ($q) {
                          $q->where('name', 'like', '%' . $this->search . '%');
                      });
            })
            ->when($this->statusFilter, function ($query) {
                $query->where('workflow_status', $this->statusFilter);
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.isbn.index', [
            'submissions' => $submissions,
        ])->layout('layouts.admin');
    }
}
