<?php

namespace App\Http\Livewire\Master;

use App\Http\Livewire\Template;
use App\Models\ProductStock;
use App\Models\StockHistory;

class Stock extends Template
{
    public $type;
    public $productStock;
    public $value;
    public $lang;
    public $mform = false;
    public $formType, $formMethod, $formAmount;
    public function mount($type)
    {

        if (!in_array(auth()->user()->role, ['master', 'operator'])) {
            return abort(403, 'Tidak Memiliki Akses');
        }

        $this->type = $type;
        $this->lang = $type == 'store' ? 'Toko' : 'Gudang';
    }

    public function form($type,  ProductStock $productStock, $cur = 0)
    {
        $this->mform = true;
        $this->formType = $type;
        $this->formMethod = $type;
        $this->productStock = $productStock;
        if ($type == 'edit') {
            $this->value = $cur;
        } else {
            $this->value = 0;
        }
    }

    public function add()
    {

        $execute = $this->productStock->increment('stock_' . $this->type, $this->value);
        if ($execute) {
            $last_amount = $this->productStock->select('stock_' . $this->type . ' as total')->first()->total;
            StockHistory::create([
                'product_id' => $this->productStock->product_id,
                'type' => $this->type,
                'status' => 'up',
                'value' => $this->value,
                'last_amount' =>  $last_amount,
                'notice' => 'Penambahan Stok '
            ]);
        }

        $this->clear();

        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Melakukan Penambahan Stok ' . $this->lang,
            'icon'        => 'success'
        ]);
    }

    public function clear()
    {
        $this->reset('mform', 'productStock', 'value');
    }

    public function export()
    {
        $l = $this->type == 'store' ? 'Gudang' : 'Toko';
        $t = $this->type == 'store' ? 'warehouse' : 'store';
        $f = $this->type == 'store' ? 'stock_warehouse' : 'stock_store';
        $i = $this->productStock->increment($f, $this->value);
        $d = $this->productStock->decrement('stock_' . $this->type, $this->value);
        if ($i) {
            $last_amount_i = $this->productStock->select($f . ' as total')->first()->total;
            StockHistory::create([
                'product_id' => $this->productStock->product_id,
                'type' => $t,
                'status' => 'up',
                'value' => $this->value,
                'last_amount' =>  $last_amount_i,
                'notice' => 'Export Stok '
            ]);
        }
        if ($d) {
            $last_amount_d = $this->productStock->select('stock_' . $this->type . ' as total')->first()->total;
            StockHistory::create([
                'product_id' => $this->productStock->product_id,
                'type' => $this->type,
                'value' => $this->value,
                'status' => 'down',
                'last_amount' =>  $last_amount_d,
                'notice' => 'Pengurangan Dari Export Stok'
            ]);
        }

        $this->clear();
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Melakukan Export Stok Dari ' . $this->lang . ' Ke Stok' .  $l,
            'icon'        => 'success'
        ]);
    }

    public function edit()
    {
        $execute = $this->productStock->update(['stock_' . $this->type => $this->value]);
        if ($execute) {

            StockHistory::create([
                'product_id' => $this->productStock->product_id,
                'type' => $this->type,
                'status' => 're',
                'value' => $this->value,
                'last_amount' =>  $this->value,
                'notice' => 'Pengeditan  Stok'
            ]);
        }
        $this->clear();
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Melakukan Edit Stok ' . $this->lang,
            'icon'        => 'success'
        ]);
    }




    public function render()
    {
        $data = ProductStock::with('product')->select('id', 'product_id', 'stock_' . $this->type . ' as total')->whereHas('product', function ($q) {
            $q->where('name', 'like', '%' . $this->searchTerm . '%');
            $q->orWhere('barcode', 'like', '%' . $this->searchTerm . '%');
        })->latest()->get();

        return view('livewire.master.stock', compact('data'));
    }
}
