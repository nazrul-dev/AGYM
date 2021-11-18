<?php

namespace App\Http\Livewire\Reports;

use App\Http\Livewire\Template;
use App\Models\Product;
use App\Models\StockHistory;
use Carbon\Carbon;


class Stock extends Template
{
    public $fstart, $fend, $ftype = 'all', $fprod = 'all';
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
        $data = StockHistory::with('product')->where(function ($q) {
            if ($this->fstart && $this->fend) {
                $q->whereBetween('created_at', [$this->fstart, $this->fend]);
            } else {
                $q->whereDate('created_at', Carbon::today());
            }

            if ($this->ftype !== 'all') {
                $q->where('type', $this->ftype);
            }
            if ($this->fprod !== 'all') {
                $q->where('product_id', $this->fprod);
            }
        })->latest()->get();

        $totals = StockHistory::where(function ($q) {
            if ($this->fstart && $this->fend) {
                $q->whereBetween('created_at', [$this->fstart, $this->fend]);
            } else {
                $q->whereDate('created_at', Carbon::today());
            }

            if ($this->ftype !== 'all') {
                $q->where('type', $this->ftype);
            }
            if ($this->fprod !== 'all') {
                $q->where('product_id', $this->fprod);
            }
        })
            ->selectRaw('count(*) as total')
            ->selectRaw("sum(case when status = 'up' THEN value ELSE 0 END) as tup")
            ->selectRaw("sum(case when status = 'down' THEN value ELSE 0 END) as tdown")

            ->first();

        $products = Product::all();

        return view('livewire.reports.stock', compact('products', 'data', 'totals'));
    }
}
