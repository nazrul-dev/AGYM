<?php

namespace App\Http\Livewire\Master;

use App\Http\Livewire\Template;
use App\Models\Category;
use App\Models\Product as ModelsProduct;


class Product extends Template
{
    public $update = false, $mform = false;
    public $product, $image;
    public $stock_w, $stock_s;
    public $mviewStock = false, $dviewStock;
    protected $listeners = ['lfmSingle'];
    protected $rules = [
        'product.name'          => 'required',
        'product.price'         => 'required|numeric',
        'product.category_id'   => 'required',
        'product.barcode'       => 'nullable',
        'stock_s'               => 'numeric|required',
        'stock_w'               => 'numeric|required',
        'product.image'         => 'nullable'

    ];
    public function lfmSingle($value)
    {
        $data = explode(',', $value);

        $this->product['image'] = $data[0];
    }

    public function mount()
    {
        if (!in_array(auth()->user()->role,['master', 'operator'])) {
            return abort(403, 'Tidak Memiliki Akses');
        }
        $this->product = new ModelsProduct();
    }

    public function viewStockTrigger($data)
    {
        $this->mviewStock  = true;
        $this->dviewStock = $data;
    }

    public function form($value = true, $id = null)
    {

        $this->reset(['mform', 'update',  'stock_s', 'stock_w']);
        $this->product['image'] = '';
        $this->product = new ModelsProduct();
        if ($value) {
            $this->update = false;
        } else {
            $r = ModelsProduct::find($id);
            if ($r) {
                $this->update = true;
                $this->product = $r;
                $this->stock_s = $r->stock->stock_store;
                $this->stock_w = $r->stock->stock_warehouse;
            };
        }
        $this->mform = true;
    }


    public function save()
    {

        $this->validate();
        $product = ModelsProduct::updateOrCreate(
            ['id' => $this->product->id],
            $this->product->toArray()
        );
        if (!$this->update) {
            $product->stock()->create([
                'stock_warehouse' => $this->stock_w,
                'stock_store' => $this->stock_s,
            ]);
        }
        $this->mform = false;
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Produk Berhasil Ditambhkan',
            'icon'        => 'success'
        ]);
    }

    public function delete(ModelsProduct $product)
    {
        $product->stock()->delete();
        $product->delete();
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Produk Berhasil Dihapus',
            'icon'        => 'success'
        ]);
    }

    public function render()
    {
        $categories = Category::get();
        $products = ModelsProduct::where(function ($q) {
            $q->where('name', 'like', '%' . $this->searchTerm . '%');
            $q->orWhere('barcode', $this->searchTerm);
        })->latest()->paginate(20);

        return view('livewire.master.product', compact('products', 'categories'));
    }
}
