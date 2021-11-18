<?php

namespace App\Http\Livewire\Transactions;

use App\Events\AfterRent;

use App\Http\Livewire\Template;
use App\Models\Transaction;

class Cash extends  Template
{
    public $field = [
        'type' => 'cashin',
        'amount' => 0,
        'notice' => ''
    ];
    public function render()
    {
        return view('livewire.transactions.pos-cash');
    }
    public function clear()
    {
        $this->reset('field');
    }
    public function submit()
    {
        $this->validate([
            'field.type' => 'required',
            'field.amount' => 'required|numeric',
        ]);
        sleep(1);

        $Transaction = Transaction::create([

            'user_id' => auth()->id(),
            'amount' => $this->field['amount'],
            'total' => $this->field['amount'],
            'paid' => $this->field['amount'],
            'paid_status' => 'fullypaid',
            'type' => $this->field['type'],
            'notice' => $this->field['notice'],
        ]);


        $this->clear();
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Melakukan Kas',
            'icon'        => 'success'
        ]);

        event(new AfterRent($Transaction));
        $this->mount();
    }
}
