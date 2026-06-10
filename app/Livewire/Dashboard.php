<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\FormSubmission;
use App\Models\Form;
use App\Models\User;

class Dashboard extends Component
{
    public $slug;

    // Workflow steps for progress tracker (linear display)
    const TRACKER_STEPS = [
        ['key' => 'data_diterima',        'label' => 'Data Diterima',        'icon' => '📥'],
        ['key' => 'verifikasi_kemenag',   'label' => 'Verifikasi Kemenag',   'icon' => '🔍'],
        ['key' => 'proses_pengajuan',     'label' => 'Proses Pengajuan',     'icon' => '📤'],
        ['key' => 'verifikasi_perpusnas', 'label' => 'Verifikasi Perpusnas', 'icon' => '📚'],
        ['key' => 'isbn_terbit',          'label' => 'ISBN Terbit',          'icon' => '✅'],
        ['key' => 'penyerahan_buku',      'label' => 'Penyerahan Buku',      'icon' => '📖'],
        ['key' => 'selesai',              'label' => 'Selesai',              'icon' => '🎉'],
    ];

    public function mount($slug)
    {
        $user = Auth::user();

        // Validate that the slug belongs to the authenticated user
        if ($user->unique_slug !== $slug) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }
    }

    public function render()
    {
        $user = Auth::user();
        $form = Form::where('slug', 'pengajuan-isbn')->first();

        $submissions = $form
            ? FormSubmission::where('form_id', $form->id)
                ->where('user_id', $user->id)
                ->latest()
                ->get()
            : collect();

        $stats = [
            'total'          => $submissions->count(),
            'in_progress'    => $submissions->whereNotIn('workflow_status', ['selesai', 'perlu_diperbaiki'])->count(),
            'perlu_perbaiki' => $submissions->where('workflow_status', 'perlu_diperbaiki')->count(),
            'selesai'        => $submissions->where('workflow_status', 'selesai')->count(),
        ];

        $pendingKckrSubmissions = $submissions->filter(function ($sub) {
            return $sub->workflow_status === 'penyerahan_buku' && (!$sub->buku_cetak_diserahkan || !$sub->buku_digital_diserahkan);
        });

        return view('livewire.dashboard', [
            'stats'                  => $stats,
            'submissions'            => $submissions->whereNotIn('workflow_status', ['selesai']),
            'pendingKckrSubmissions' => $pendingKckrSubmissions,
            'trackerSteps'           => self::TRACKER_STEPS,
        ])->layout('layouts.app');
    }
}
