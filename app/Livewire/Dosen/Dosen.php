<?php

namespace App\Livewire\Dosen;

use App\Models\Kegiatan;
use Livewire\Component;
use Livewire\WithPagination;

class Dosen extends Component
{
    use WithPagination;

    public function approve($id)
    {
        $kegiatan = Kegiatan::where('id', $id)
            ->where('status', 'under_review')
            ->first();

        if ($kegiatan) {
            $kegiatan->update(['status' => 'approved']);
            session()->flash('message', 'Kegiatan berhasil disetujui.');
        }
    }

    public function unapprove($id)
    {
        $kegiatan = Kegiatan::where('id', $id)
            ->where('status', 'under_review')
            ->first();

        if ($kegiatan) {
            $kegiatan->update(['status' => 'rejected']);
            session()->flash('message', 'Kegiatan ditolak.');
        }
    }

    public function render()
    {
        return view('livewire.dosen.dosen', [
            'kegiatans' => Kegiatan::where('status', 'under_review')->paginate(10),
        ]);
    }
}

