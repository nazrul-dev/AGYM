<?php

namespace App\Http\Livewire;


use App\Http\Livewire\Template;
use App\Models\Simpanan as ModelsSimpanan;

class Simpanan extends Template
{
    public $mpay = false, $ids, $total, $amount, $semua = false, $change = 0;
    public function render()
    {
        $data = ModelsSimpanan::where(function ($q) {
            $q->where('f_name', 'like', '%' . $this->searchTerm . '%');
            $q->orWhere('l_name', 'like', '%' . $this->searchTerm . '%');
        })->where('habis', false)->latest()->get();

        return view('livewire.simpanan', compact('data'));
    }
    public function updatedSemua()
    {
        $this->reset('amount', 'change');
        if ($this->semua) {
            $this->amount = $this->total;
            $this->change = 0;
        }
    }
    public function  updatedAmount($value)
    {
        if ($value) {
            if ($value > $this->total) {
                $this->amount = $this->total;
                $this->change = 0;
            } else {
                $this->change = ($this->total - $value);
            }
        }
    }

    public function delete(ModelsSimpanan $simpanan)
    {

        $simpanan->delete();
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Simpanan Berhasil Dihapus',
            'icon'        => 'success'
        ]);
    }

    public function pay($total, $id)
    {
        $this->total = null;
        $this->ids = null;
        $this->mpay = true;
        $this->total = $total;
        $this->ids = $id;
    }

    public function submit()
    {
        $this->validate([
            'amount' => 'required|numeric'
        ]);
        $q = ModelsSimpanan::find($this->ids);
        if ($q) {
            $q->update([
                'amount' => $this->amount >= $q->amount ? 0 : ($q->amount - $this->amount),
                'habis' => $this->amount >= $q->amount ? true : false
            ]);
        }

        $this->reset('ids', 'amount', 'change', 'semua', 'mpay', 'total');
        return  $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Mengembalikan Uang Simpanan',
            'icon'        => 'success',
            'onClose' => [
                'method' => 'render',

            ],
            'onDismiss' => [
                'method' => 'render',

            ],
            'onTimeout' => [
                'method' => 'render',

            ],
        ]);
    }
}
