<?php

namespace App\Http\Livewire;

use App\Http\Livewire\Template;
use App\Models\Member;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Transaction;
use Carbon\Carbon;

class Dashboard extends Template
{
    public function render()
    {

        $member['total'] = Member::count();
        $member['expired'] = Member::whereHas('subscription', function ($q) {
            $q->where('expired_at', '<=', Carbon::now());
        })->count();
        $member['active'] = Member::whereHas('subscription', function ($q) {
            $q->where('expired_at', '>', Carbon::now());
        })->count();
        $product = Product::count();
        $pendapatanToday = Transaction::where('type', '!=', 'cashout')->whereDate('created_at', Carbon::today())->sum('total');
        $pengeluaranToday = Transaction::where('type', 'cashout')->whereDate('created_at', Carbon::today())->sum('total');
        $newMember = Member::whereDate('created_at', Carbon::today())->latest()->get();
        $saleToday = Transaction::where('type', 'sale')->whereDate('created_at', Carbon::today())->latest()->get();
        $stock['warehouse'] = ProductStock::with('product')->select('id', 'product_id', 'stock_warehouse as total')->where('stock_warehouse','<=',1)->latest()->get();
        $stock['store'] = ProductStock::with('product')->select('id', 'product_id', 'stock_store as total')->where('stock_store','<=',1)->latest()->get();


        return view('livewire.dashboard', compact('member', 'product', 'pendapatanToday', 'pengeluaranToday', 'newMember', 'stock', 'saleToday'));
    }
}
