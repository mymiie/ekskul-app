<?php

namespace App\Livewire\User;

use App\Models\Ekskul;
use App\Models\Pendaftaran;
use App\Models\Pendaftarans;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class EkskulList extends Component
{
    public $showModal = false;
    public $selectedEkskul = null;
    public $alasanDaftar = '';

    public function selectEkskul($ekskulId)
    {
        $this->selectedEkskul = Ekskul::findOrFail($ekskulId);
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->selectedEkskul = null;
        $this->alasanDaftar = '';
    }

    public function daftarEkskul()
    {
        $this->validate([
            'alasanDaftar' => 'required|min:10|max:500',
        ]);

        // Check if already registered
        $existingRegistration = Pendaftarans::where('user_id', Auth::id())
                                          ->where('ekskul_id', $this->selectedEkskul->id)
                                          ->first();

        if ($existingRegistration) {
            session()->flash('error', 'Anda sudah mendaftar untuk ekstrakurikuler ini.');
            $this->closeModal();
            return;
        }

        // Check if ekskul is full
        if ($this->selectedEkskul->isFull()) {
            session()->flash('error', 'Ekstrakurikuler ini sudah penuh.');
            $this->closeModal();
            return;
        }

        Pendaftarans::create([
            'user_id' => Auth::id(),
            'ekskul_id' => $this->selectedEkskul->id,
            'alasan_daftar' => $this->alasanDaftar,
            'status' => 'pending',
            'tanggal_daftar' => now(),
        ]);

        session()->flash('success', 'Pendaftaran berhasil! Menunggu persetujuan admin.');
        $this->closeModal();
    }

    public function render()
    {
        $ekskuls = Ekskul::where('status_aktif', true)
                         ->with('guru', 'pendaftarans')
                         ->get();

        $userRegistrations = Pendaftarans::where('user_id', Auth::id())
                                       ->pluck('ekskul_id')
                                       ->toArray();

        return view('livewire.user.ekskul-list', compact('ekskuls', 'userRegistrations'));
    }
}