<?php

namespace App\Livewire\Himpunan;

use App\Models\Kegiatan;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public $viewType = "table";


    public function toggleView($type)
    {
        if (in_array($type, ['table', 'card'])) {
            $this->viewType = $type;
            $this->resetPage();
        }
    }

    public function render()
    {
        return view('livewire.himpunan.index', [
            'kegiatans' => Kegiatan::where('created_by', auth()->id())->paginate(10),
        ]);
    }

    public function delete($id)
    {
        $kegiatan = Kegiatan::where('id', $id)
            ->where('created_by', auth()->id())
            ->first();

        if ($kegiatan) {
            $kegiatan->delete();
            session()->flash('message', 'Kegiatan berhasil dihapus.');
        } else {
            session()->flash('message', 'Kegiatan tidak ditemukan atau tidak diizinkan.');
        }
    }
}
