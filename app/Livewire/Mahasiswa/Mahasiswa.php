<?php

namespace App\Livewire\Mahasiswa;

use App\Models\Kegiatan;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Mahasiswa extends Component
{
    use WithPagination;

    public function daftar($id)
    {
        $user = Auth::user();

        if ($user->kegiatanDiikuti()->where('kegiatan.id', $id)->exists()) {
            session()->flash('message', 'Anda sudah mendaftar kegiatan ini.');
            return;
        }

        $kegiatan = Kegiatan::findOrFail($id);

        if ($kegiatan->peserta()->count() >= $kegiatan->kuota) {
            session()->flash('message', 'Kegiatan sudah penuh.');
            return;
        }

        $user->kegiatanDiikuti()->attach($id);
        session()->flash('message', 'Berhasil mendaftar kegiatan.');
    }

    public function render()
    {
        $kegiatans = Kegiatan::with(['pembuat'])
            ->withCount('peserta')
            ->where('status', 'approved')
            ->havingRaw('peserta_count < kuota')
            ->paginate(10);
        return view('livewire.mahasiswa.mahasiswa', compact('kegiatans'));
    }
}

