<?php

namespace App\Livewire\Admin\Forms;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Form;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function delete($id)
    {
        $form = Form::findOrFail($id);
        $form->delete();
        session()->flash('message', 'Formulir berhasil dihapus.');
    }

    public function render()
    {
        $forms = Form::query()
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('slug', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.forms.index', [
            'forms' => $forms
        ])->layout('layouts.app'); // Assuming 'layouts.app' is the admin layout based on previous context, or checking sidebar.
    }
}
