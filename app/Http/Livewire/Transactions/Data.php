<?php

namespace App\Http\Livewire\Transactions;

use App\Http\Livewire\Template;
use App\Models\Transaction;


class Data extends Template
{
    public function render()
    {
        $data = Transaction::where(function ($q) {
            $q->where('invoice', 'like', '%' . $this->searchTerm . '%');

        })->latest()->paginate(12);
        return view('livewire.transactions.data', compact('data'));
    }

    public function delete(Transaction $transaction){
        // if($transaction->orders){

        // }
        $transaction->delete();
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Transaksi Berhasil Dihapus',
            'icon'        => 'success'
        ]);
    }
}
