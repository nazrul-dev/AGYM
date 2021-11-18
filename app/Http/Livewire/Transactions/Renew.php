<?php

namespace App\Http\Livewire\Transactions;

use App\Events\AfterRenew;
use App\Http\Livewire\Template;
use App\Models\Member;
use App\Models\Simpanan;
use App\Models\Transaction;
use stdClass;

class Renew extends  Template
{
    public $simpansisa = false;
    public $formcheckout = false;
    public $memberSelected = null;
    public $memberHasSelected = [];
    public $biayaRenew = 0, $discount = 0;
    public $dibayar = 0, $kembalian = 0, $notice;

    public function mount()
    {
        $this->biayaRenew = config('global.biaya_perpanjang_member');
    }
    public function render()
    {
        $members = Member::latest()->get();
        return view('livewire.transactions.pos-renew', compact('members'));
    }

    public function updatedMemberSelected($value)
    {
        $this->clear();
        $this->memberSelected = $value;
        $this->memberHasSelected = Member::find($value);
    }

    public function updatingDiBayar($value)
    {
        if ($value) {

            $this->kembalian = (($value - $this->biayaRenew) + $this->discount);
        }
    }

    public function updatingDiscount($value)
    {
        if ($value) {

            $this->kembalian = (($this->dibayar - $this->biayaRenew) + $value);
        }
    }


    public function clear()
    {
        $this->memberHasSelected = [];
        $this->reset('dibayar', 'discount', 'simpansisa', 'memberSelected', 'kembalian', 'notice', 'formcheckout');
    }
    public function renew()
    {

        if (!$this->memberSelected) {
            return $this->notification()->notify([
                'title'       => 'Sukses',
                'description' => 'Harap Memilih Member Terlebih Dahulu',
                'icon'        => 'error'
            ]);
        }
        $this->dibayar = $this->biayaRenew;
        $this->kembalian = 0;
        return $this->formcheckout = true;
    }

    public function submit()
    {
        $this->validate([
            'dibayar' => 'required|numeric',
        ]);
        sleep(1);
        $data = new stdClass();
        $data->transaction = Transaction::create([
            'customers' => json_encode($this->memberHasSelected),
            'user_id' => auth()->id(),
            'member_id' => $this->memberHasSelected->id,
            'amount' => $this->biayaRenew,
            'discount' => $this->discount,
            'total' => ($this->biayaRenew - $this->discount),
            'paid' => ($this->dibayar),
            'paid_status' => 'fullypaid',
            'type' => 'renew_member',
            'notice' => $this->notice,
        ]);
        if ($this->simpansisa) {
            if ($this->dibayar > $this->biayaRenew || $this->kembalian > 0) {
                Simpanan::create([
                    'f_name' =>  $this->memberHasSelected->first_name,
                    'l_name' =>  $this->memberHasSelected->last_name,
                    'amount' => (($this->dibayar - $this->biayaRenew) + $this->discount)
                ]);
            }
        }
        $data->member = $this->memberHasSelected;
        event(new AfterRenew($data));
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Memperpanjang Akun Member',
            'icon'        => 'success',
            'onClose' => [
                'method' => 'redirectInfoTransaksi',
                'params' => $data->transaction->id,
            ],
            'onDismiss' => [
                'method' => 'redirectInfoTransaksi',
                'params' => $data->transaction->id,
            ],
            'onTimeout' => [
                'method' => 'redirectInfoTransaksi',
                'params' => $data->transaction->id,
            ],
        ]);

        $this->clear();
    }
}
