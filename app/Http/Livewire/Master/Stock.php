<?php

namespace App\Http\Livewire\Master;

use App\Http\Livewire\Template;
use App\Models\ProductStock;


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

            if (!in_array(auth()->user()->role,['master', 'operator'])) {
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

        $this->productStock->increment('stock_' . $this->type, $this->value);
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
        $this->productStock->increment($this->type == 'store' ? 'stock_warehouse' : 'stock_store', $this->value);
        $this->productStock->decrement('stock_' . $this->type, $this->value);
        $this->clear();
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Melakukan Export Stok Dari ' . $this->lang . ' Ke Stok' .  $l,
            'icon'        => 'success'
        ]);
    }

    public function edit()
    {
        $this->productStock->update(['stock_' . $this->type => $this->value]);
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
