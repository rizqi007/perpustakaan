<?php

namespace App\Livewire\Admin\Users;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;

class Index extends Component
{
    use WithPagination;

    public $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleAdmin($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent self-demotion if only one admin? Or just check current user.
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat mengubah role akun sendiri.');
            return;
        }

        $user->role = $user->role === 'admin' ? 'user' : 'admin';
        $user->save();

        session()->flash('message', 'Role user berhasil diubah.');
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        
        if ($user->id === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun sendiri.');
            return;
        }

        $user->delete();
        session()->flash('message', 'User berhasil dihapus.');
    }

    public function render()
    {
        $users = User::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.users.index', [
            'users' => $users
        ])->layout('layouts.admin');
    }
}
