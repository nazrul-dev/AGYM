<?php

namespace App\Http\Livewire\Transactions;

use App\Models\Transaction;
use Livewire\Component;

class Info extends Component
{   public Transaction $transaction;
    public function render()
    {
        return view('livewire.transactions.info');
    }
}
