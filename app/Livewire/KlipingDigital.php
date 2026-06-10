<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\KlipingDigital as KlipingModel;

class KlipingDigital extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedYear = '';
    public $selectedSource = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedYear()
    {
        $this->resetPage();
    }

    public function updatedSelectedSource()
    {
        $this->resetPage();
    }

    public function setYear($year)
    {
        $this->selectedYear = $year;
        $this->resetPage();
    }

    public function setSource($source)
    {
        $this->selectedSource = $source;
        $this->resetPage();
    }

    public function render()
    {
        $query = KlipingModel::query();

        if ($this->search) {
            $query->where(function($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                  ->orWhere('author', 'like', '%' . $this->search . '%')
                  ->orWhere('source', 'like', '%' . $this->search . '%')
                  ->orWhere('topic', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->selectedYear) {
            $query->whereYear('published_at', $this->selectedYear);
        }

        if ($this->selectedSource) {
            $query->where('source', $this->selectedSource);
        }

        $years = KlipingModel::selectRaw('YEAR(published_at) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');

        $sources = KlipingModel::select('source')
            ->distinct()
            ->orderBy('source')
            ->pluck('source');

        return view('livewire.kliping-digital', [
            'klipings' => $query->latest('published_at')->paginate(12),
            'years' => $years,
            'sources' => $sources,
        ])->layout('layouts.public');
    }
}
