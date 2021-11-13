<?php

namespace App\Http\Livewire\Loan;

use App\Http\Livewire\Template;
use App\Models\Transaction;


class Data extends Template
{
    public $mpay = false;
    public $sisa = 0, $dibayar = 0, $change = 0, $lunas = false, $ids;
    public function pay($value, $ids)
    {
        $this->mpay = true;
        $this->sisa = $value;
        $this->ids = $ids;
    }
    public function render()
    {
        $data = Transaction::where('paid_status', 'paylater')->latest()->get();
        return view('livewire.loan.data', compact('data'));
    }
    public function updatedLunas()
    {
        $this->reset('dibayar', 'change');
    }
    public function  updatedDibayar($value)
    {
        if ($value > $this->sisa) {
            $this->dibayar = $this->sisa;
        }
        $this->change = ($this->sisa - $value);
    }

    public function submit()
    {
        $trans = Transaction::find($this->ids);
        if ($this->lunas) {

            $kas = Transaction::create([

                'user_id' => auth()->id(),
                'amount' => $trans->change,
                'total' => $trans->change,
                'paid' => $trans->change,
                'paid_status' => 'fullypaid',
                'type' => 'cashin',
                'notice' => 'Pembayaran Piutang Dari Invoice '.$trans->invoice,
            ]);
            $trans->paid_status = 'lunas';
            $trans->paid = $trans->total;
            $trans->change = 0;
            $trans->save();
        } else {
            $kas = Transaction::create([

                'user_id' => auth()->id(),
                'amount' => $this->dibayar >= $trans->change ?  $trans->change : $this->dibayar,
                'total' => $this->dibayar >= $trans->change ?  $trans->change : $this->dibayar,
                'paid' => $this->dibayar >= $trans->change ?  $trans->change : $this->dibayar,
                'paid_status' => 'fullypaid',
                'type' => 'cashin',
                'notice' => 'Pembayaran Piutang Dari Invoice '.$trans->invoice,
            ]);
            $trans->update([
                'paid_status' => $this->dibayar >= $trans->change ?  'lunas' : 'paylater',
                'paid' => $this->dibayar >= $trans->change ?  $trans->total : $this->dibayar,
                'change' => $this->dibayar >= $trans->change ? 0 : $this->change,
            ]);
        }
        $this->reset('dibayar', 'change', 'sisa', 'ids', 'lunas', 'mpay');
        return  $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Melakukan Pembayaran Piutang',
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
