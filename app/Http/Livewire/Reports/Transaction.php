<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\Template;
use App\Models\Transaction as ModelsTransaction;
use Carbon\Carbon;

class Transaction extends Template
{
    public $fstart, $fend, $ftype = 'all';
    public function mount()
    {
        if (!in_array(auth()->user()->role, ['master', 'operator'])) {
            return abort(403, 'Tidak Memiliki Akses');
        }
    }
    public function filter()
    {
    }
    public function render()
    {
        $data = ModelsTransaction::where(function ($q) {
            if ($this->fstart && $this->fend) {
                $q->whereBetween('created_at', [$this->fstart, $this->fend]);
            } else {
                $q->whereDate('created_at', Carbon::today());
            }

            if ($this->ftype !== 'all') {
                $q->where('type', $this->ftype);
            }
        })->latest()->get();

        $totals = ModelsTransaction::where(function ($q) {
            if ($this->fstart && $this->fend) {
                $q->whereBetween('created_at', [$this->fstart, $this->fend]);
            } else {
                $q->whereDate('created_at', Carbon::today());
            }

            if ($this->ftype !== 'all') {
                $q->where('type', $this->ftype);
            }
        })
            ->selectRaw('count(*) as total')
            ->selectRaw("sum(case when type = 'cashout' THEN total ELSE 0 END) as pengeluaran")
            ->selectRaw("sum(case when type != 'cashout' THEN total ELSE 0 END) as pendapatan")

            ->first();


        return view('livewire.reports.transaction', compact('data', 'totals'));
    }
}
