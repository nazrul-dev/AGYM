<?php

namespace App\Http\Livewire\Transactions;

use App\Events\AfterSale;
use App\Http\Livewire\Template;
use App\Models\Product as ModelsProduct;
use App\Models\ProductStock;
use App\Models\Simpanan;
use App\Models\StockHistory;
use App\Models\Transaction;

class Product extends Template
{
    public $mcart = false;
    public $mqty = false;
    public $qty = 0;
    public $tunai = false;
    public $productSeleced;
    public $pelanggan;
    public $panjar = 0, $sisa = 0;
    public $dibayar = 0, $kembalian = 0;
    public $notice = '';
    public $duedate;
    public $mcheckout = false;
    public $simpansisa = false;

    public function mount()
    {
        $this->pelanggan['first_name'] = '';
        $this->pelanggan['last_name'] = '';
    }
    public function prodSelected(ModelsProduct $product)
    {
        $this->productSeleced = $product;
        $this->mqty = true;
    }

    public function checkout()
    {
        if (\Cart::session(auth()->id())->isEmpty()) {
            return $this->notification()->notify([
                'title'       => 'Pesan',
                'description' => 'Keranjang Masih Kosong, Harap Mengisi Keranjang Sebelum Melakukan Checkout',
                'icon'        => 'error'
            ]);
        }
        $this->mcheckout = true;
    }

    public function render()
    {
        $cart['total'] = \Cart::session(auth()->id())->getTotal();
        $cart['contents'] = \Cart::session(auth()->id())->getContent();
        $cart['tqty'] = \Cart::session(auth()->id())->getTotalQuantity();

        $products = ModelsProduct::whereHas('stock', function ($q) {
            $q->where('stock_store', '>=', 1);
        })->whereHas('category', function ($q) {
            $q->where('name', 'like', '%' . $this->searchTerm . '%');
        })->orWhere(function ($q) {
            $q->where('name', 'like', '%' . $this->searchTerm . '%');
            $q->orWhere('barcode', 'like', '%' . $this->searchTerm . '%');
        })->latest()->get();
        return view('livewire.transactions.pos-product', compact('products', 'cart'));
    }

    public function updatingTunai()
    {
        $this->reset('panjar', 'sisa', 'kembalian', 'dibayar');
    }

    public function  updatingPanjar(int $value)
    {
        if ($value) {
            $total = (int) \Cart::session(auth()->id())->getTotal();

            if ($value > $total) {
                $this->panjar = $total;
                $this->sisa = 0;
            } else {
                $this->sisa = $total - $value;
            }
        }
    }

    public function  updatingDibayar($value)
    {
        if ($value) {
            $total = \Cart::session(auth()->id())->getTotal();
            $this->kembalian = ($value -  $total);
        }
    }

    public function changeQty($rowId, $type, int $qty)
    {

        if ($type == 'up') {
            $a = '+1';
        } else {
            $a = '-1';
        }

        \Cart::session(auth()->id())->update($rowId, [
            'quantity' => $a,
        ]);
    }

    public function cartClear()
    {
        \Cart::session(auth()->id())->clear();
    }


    public function deleteCart($rowId)
    {
        \Cart::session(auth()->id())->remove($rowId);
    }

    public function addCart()
    {
        $this->validate([
            'qty' => 'required|min:1|numeric'
        ]);
        \Cart::session(auth()->id())->add(array(
            'id' => $this->productSeleced->id,
            'name' => $this->productSeleced->name,
            'price' => $this->productSeleced->price,
            'quantity' => $this->qty,
        ));

        $this->reset('productSeleced', 'qty', 'mqty');
    }

    public function submit()
    {

        $total = \Cart::session(auth()->id())->getTotal();

        if (!$this->tunai) {
            if ($this->panjar > $total) {
                $this->mcheckout = false;

                return  $this->notification()->notify([
                    'title'       => 'Error',
                    'description' => 'Jumlah Panjar Tidak Bisa Lebih Dari Total Belanja',
                    'icon'        => 'error',
                ]);
            }
        } else {
            if ($this->dibayar < $total) {
                $this->mcheckout = false;

                return  $this->notification()->notify([
                    'title'       => 'Error',
                    'description' => 'Jumlah Pembayaran Kurang Dari Total Belanja',
                    'icon'        => 'error',
                ]);
            }
        }

        $Transaction = Transaction::create([
            'customers' => json_encode($this->pelanggan),
            'user_id' => auth()->id(),
            'orders' => json_encode(\Cart::session(auth()->id())->getContent(), true),
            'due_date' => $this->tunai ? null : $this->duedate,
            'amount' => $total,
            'total' => $this->tunai ? $total : $this->panjar,
            'change' => $this->tunai ? 0 : ($total - $this->dibayar),
            'paid' => $this->tunai ? $this->dibayar : $this->panjar,
            'paid_status' => $this->tunai ? 'fullypaid' : 'paylater',
            'type' => 'sale',
            'notice' => $this->notice,
        ]);

        foreach (\Cart::session(auth()->id())->getContent() as $order) {
            $prod = ProductStock::where('product_id', $order['id'])->first();
            $prod->decrement('stock_store', $order['quantity']);
            $prod->increment('stock_sold', $order['quantity']);
            $last_amount = $prod->stock_store;
            StockHistory::create([
                'product_id' => $order['id'],
                'type' => 'store',
                'status' => 'down',
                'value' => $order['quantity'],
                'last_amount' =>  $last_amount,
                'notice' => 'Pengurangan  Stok Dari Penjualan'
            ]);
        }
        if ($this->simpansisa && $this->tunai) {
            if ($this->dibayar > $total || $this->kembalian > 0) {
                Simpanan::create([
                    'f_name' =>  $this->pelanggan['first_name'],
                    'l_name' =>  $this->pelanggan['last_name'],
                    'amount' => ($this->dibayar - $total)
                ]);
            }
        }


        $this->cartClear();
        $this->clear();


        // event(new AfterSale($Transaction));
        return  $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Melakukan Penjualan Produk',
            'icon'        => 'success',
            'onClose' => [
                'method' => 'redirectInfoTransaksi',
                'params' =>  $Transaction->id,
            ],
            'onDismiss' => [
                'method' => 'redirectInfoTransaksi',
                'params' =>  $Transaction->id,
            ],
            'onTimeout' => [
                'method' => 'redirectInfoTransaksi',
                'params' =>  $Transaction->id,
            ],
        ]);
    }

    public function clear()
    {
        $this->reset('panjar', 'simpansisa', 'sisa', 'kembalian', 'dibayar', 'pelanggan', 'mcart', 'mqty', 'qty', 'tunai', 'productSeleced', 'notice', 'duedate', 'mcheckout');
    }
}
