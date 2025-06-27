<?php
namespace App\Livewire\Himpunan;

use App\Models\Kegiatan;
use Livewire\Component;

class Form extends Component
{
    public function render()
    {
        return view('livewire.himpunan.form');
    }

    public $isEdit = false;
    public $kegiatanId;
    public $judul = '';
    public $deskripsi = '';
    public $kuota = '';


    public function mount($id = null)
    {
        if ($id) {
            $kegiatan = Kegiatan::findOrFail($id);
            $this->fill($kegiatan->toArray());
            $this->kegiatanId = $id;
            $this->isEdit = true;
        }
    }

    public function rules()
    {
        return [
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'kuota' => 'required|integer|min:0',
        ];
    }

    public function save()
    {
        $data = $this->validate();
        if ($this->kegiatanId) {
            Kegiatan::findOrFail($this->kegiatanId)->update($data);
            session()->flash('message', 'Kegiatan berhasil diperbarui.');
        } else {
            $data['status'] = 'submitted';
            $data['created_by'] = auth()->user()->id;
            Kegiatan::create($data);
            session()->flash('message', 'Kegiatan berhasil dibuat.');
        }

        return redirect()->route('himpunan.kegiatan.index');
    }
}
