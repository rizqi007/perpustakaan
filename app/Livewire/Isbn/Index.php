<?php

namespace App\Livewire\Isbn;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FormSubmission;
use App\Models\Form;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    protected $queryString = [
        'search' => ['except' => ''],
        'statusFilter' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $form = Form::where('slug', 'pengajuan-isbn')->first();

        if ($form) {
            $query = FormSubmission::where('form_id', $form->id)
                ->where('user_id', Auth::id());

            if (!empty($this->search)) {
                $search = $this->search;
                $query->where(function ($q) use ($search) {
                    $q->where('data->Judul', 'like', "%{$search}%")
                      ->orWhere('data->judul', 'like', "%{$search}%")
                      ->orWhere('data->Judul Naskah', 'like', "%{$search}%")
                      ->orWhere('data->Judul Buku', 'like', "%{$search}%")
                      ->orWhere('data->Penulis', 'like', "%{$search}%")
                      ->orWhere('data->penulis', 'like', "%{$search}%")
                      ->orWhere('isbn_number', 'like', "%{$search}%");
                });
            }

            if (!empty($this->statusFilter)) {
                $query->where('workflow_status', $this->statusFilter);
            }

            $submissions = $query->latest()->paginate(10);
        } else {
            $submissions = collect()->paginate(10);
        }

        return view('livewire.isbn.index', [
            'submissions' => $submissions,
            'form'        => $form,
        ])->layout('layouts.app');
    }
}
