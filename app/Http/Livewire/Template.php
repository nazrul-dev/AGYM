<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use WireUi\Traits\Actions;

class Template extends Component
{
    public $searchTerm = '';
    use Actions, WithPagination, WithFileUploads;
    public function render()
    {
        return view('livewire.template');
    }

    public function updatedSearchTerm()
    {
        $this->resetPage();
    }

    public function triggerConfirm($method, $params = null)
    {
        $this->dialog()->confirm([
            'title'       => 'Apakah Kamu Yakin  ?',
            'description' => 'Untuk Menghapus Data Ini',
            'icon'        => 'error',
            'accept'      => [
                'label'  => 'Ya',
                'method' => $method,
                'params' => $params,
            ],
        ]);
    }

    public function redirectInfoTransaksi($id)
    {
        return redirect()->to(route('transaction.info', $id));
    }
}
