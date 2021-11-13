<?php

namespace App\Http\Livewire\Transactions;

use App\Events\AfterRent;
use App\Http\Livewire\Template;
use App\Models\Transaction;

class Rent extends Template
{

    public $guest;
    public $formcheckout = false;
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

    public function checkout(){
        $this->validate([
            'guest.first_name' => 'required',
            'guest.last_name' => 'nullable',
        ]);
        sleep(1);
        $this->dibayar = $this->biayaRent;
        $this->kembalian = 0;
        $this->formcheckout = true;
    }


    public function updatingDiBayar($value){


        $this->kembalian = ($value - $this->biayaRent);
    }

    public function clear(){
        $this->reset('guest', 'formcheckout', 'dibayar', 'kembalian','notice');
    }


    public function submit(){
        $this->validate([
            'dibayar' => 'required|numeric',
        ]);
        sleep(1);
            dd($this->notice);
        $Transaction = Transaction::create([
            'customers' => json_encode($this->guest),
            'user_id' => auth()->id(),
            'amount' => $this->biayaRent,
            'total' => $this->biayaRent,
            'paid' => $this->dibayar,
            'paid_status' => 'fullypaid',
            'type' => 'rent',
            'notice' => $this->notice,
        ]);


        $this->clear();
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Menyewakan Gym',
            'icon'        => 'success'
        ]);

        event(new AfterRent($Transaction));
        $this->mount();
    }
}
