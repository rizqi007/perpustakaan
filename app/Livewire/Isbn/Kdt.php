<?php

namespace App\Livewire\Isbn;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\FormSubmission;
use App\Models\Form;
use Illuminate\Support\Facades\Auth;

class Kdt extends Component
{
    use WithPagination;

    public function render()
    {
        $form = Form::where('slug', 'pengajuan-isbn')->first();

        $submissions = $form
            ? FormSubmission::where('form_id', $form->id)
                ->where('user_id', Auth::id())
                ->where(function($query) {
                    $query->whereNotNull('kdt_text')
                          ->where('kdt_text', '!=', '')
                          ->orWhereNotNull('kdt_file');
                })
                ->whereIn('workflow_status', ['isbn_terbit', 'penyerahan_buku', 'selesai'])
                ->latest()
                ->paginate(10)
            : collect()->paginate(10);

        return view('livewire.isbn.kdt', [
            'submissions' => $submissions,
            'form'        => $form,
        ])->layout('layouts.app');
    }
}
