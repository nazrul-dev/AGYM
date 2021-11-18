<?php

namespace App\Http\Livewire\Transactions;

use App\Events\AfterRent;
use App\Http\Livewire\Template;
use App\Models\Simpanan;
use App\Models\Transaction;

class Rent extends Template
{
    public $simpansisa = false;
    public $guest;
    public $formcheckout = false;
    public $discount = 0;
    public $dibayar = 0, $kembalian = 0, $notice;
    public $biayaRent =   0;
    public function mount()
    {
        $this->biayaRent = config('global.biaya_sewa_gym');
        $this->guest['first_name'] = '';
        $this->guest['last_name'] = '';
    }
    public function render()
    {
        return view('livewire.transactions.pos-rent');
    }

    public function checkout()
    {
        $this->validate([
            'guest.first_name' => 'required',
            'guest.last_name' => 'nullable',
        ]);
        sleep(1);
        $this->dibayar = $this->biayaRent;
        $this->kembalian = 0;
        $this->formcheckout = true;
    }


    public function updatingDiBayar($value)
    {

        if ($value) {
            $this->kembalian = (($value - $this->biayaRent) + $this->discount);
        }
    }

    public function updatingDiscount($value)
    {
        if ($value) {

            $this->kembalian = (($this->dibayar - $this->biayaRent) + $value);
        }
    }
    public function clear()
    {
        $this->reset('guest', 'discount', 'simpansisa', 'formcheckout', 'dibayar', 'kembalian', 'notice');
    }


    public function submit()
    {
        $this->validate([
            'dibayar' => 'required|numeric',
        ]);
        sleep(1);

        $Transaction = Transaction::create([
            'customers' => json_encode($this->guest),
            'user_id' => auth()->id(),
            'discount' => $this->discount,
            'amount' => $this->biayaRent,
            'total' => ($this->biayaRent - $this->discount),
            'paid' => $this->dibayar,
            'paid_status' => 'fullypaid',
            'type' => 'rent',
            'notice' => $this->notice,
        ]);

        if ($this->simpansisa) {
            if ($this->dibayar > $this->biayaRent || $this->kembalian > 0) {
                Simpanan::create([
                    'f_name' =>  $this->guest['first_name'],
                    'l_name' =>  $this->guest['last_name'],
                    'amount' => (($this->dibayar - $this->biayaRent) + $this->discount)
                ]);
            }
        }

        event(new AfterRent($Transaction));
        $this->clear();
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Menyewakan Gym',
            'icon'        => 'success',
            'onClose' => [
                'method' => 'redirectInfoTransaksi',
                'params' => $Transaction->id,
            ],
            'onDismiss' => [
                'method' => 'redirectInfoTransaksi',
                'params' => $Transaction->id,
            ],
            'onTimeout' => [
                'method' => 'redirectInfoTransaksi',
                'params' => $Transaction->id,
            ],
        ]);

        $this->mount();
    }
}
