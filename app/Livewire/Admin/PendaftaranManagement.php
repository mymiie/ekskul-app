<?php

namespace App\Livewire\Admin;

use App\Models\Pendaftaran;
use App\Models\Ekskul;
use App\Models\Pendaftarans;
use Livewire\Component;
use Livewire\WithPagination;

class PendaftaranManagement extends Component
{
    use WithPagination;

    public $selectedEkskul = '';
    public $statusFilter = '';
    public $search = '';
    
    public $showDetailModal = false;
    public $selectedPendaftaran = null;
    public $catatanAdmin = '';

    protected $queryString = ['search', 'selectedEkskul', 'statusFilter'];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedEkskul()
    {
        $this->resetPage();
    }

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function showDetail($pendaftaranId)
    {
        $this->selectedPendaftaran = Pendaftarans::with('user', 'ekskul')->findOrFail($pendaftaranId);
        $this->catatanAdmin = $this->selectedPendaftaran->catatan_admin ?? '';
        $this->showDetailModal = true;
    }

    public function closeModal()
    {
        $this->showDetailModal = false;
        $this->selectedPendaftaran = null;
        $this->catatanAdmin = '';
    }

    public function updateStatus($status)
    {
        $this->selectedPendaftaran->update([
            'status' => $status,
            'catatan_admin' => $this->catatanAdmin,
        ]);

        session()->flash('success', 'Status pendaftaran berhasil diperbarui.');
        $this->closeModal();
    }

    public function render()
    {
        $query = Pendaftarans::with(['user', 'ekskul'])
                           ->when($this->search, function($q) {
                               $q->whereHas('user', function($query) {
                                   $query->where('name', 'like', '%' . $this->search . '%')
                                         ->orWhere('nis', 'like', '%' . $this->search . '%');
                               });
                           })
                           ->when($this->selectedEkskul, function($q) {
                               $q->where('ekskul_id', $this->selectedEkskul);
                           })
                           ->when($this->statusFilter, function($q) {
                               $q->where('status', $this->statusFilter);
                           })
                           ->latest();

        $pendaftarans = $query->paginate(10);
        $ekskuls = Ekskul::all();

        return view('livewire.admin.pendaftaran-management', compact('pendaftarans', 'ekskuls'));
    }
}