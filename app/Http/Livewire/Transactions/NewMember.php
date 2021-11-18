<?php

namespace App\Http\Livewire\Transactions;

use App\Events\AfterNewMember;
use App\Http\Livewire\Template;
use App\Models\Member;
use App\Models\Simpanan;
use App\Models\Transaction;


class NewMember extends Template
{

    public $member;
    public $formcheckout = false;
    public $dibayar = 0, $kembalian = 0, $notice, $discount = 0;
    public $simpansisa = false;
    public $biayaPendaftaran =   0;
    protected $rules = [
        'member.first_name'    => 'required',
        'member.last_name'     => 'nullable',
        'member.email'         => 'nullable',
        'member.phone'         => 'nullable',
        'member.address'       => 'nullable',
        'member.type'          => 'nullable',
        'member.identity'      => 'nullable',
    ];


    public function mount()
    {
        $this->biayaPendaftaran = config('global.biaya_pendaftaran_member');
        $this->member = new Member();
    }

    public function render()
    {
        return view('livewire.transactions.pos-new-member');
    }

    public function checkout()
    {
        $this->validate();
        sleep(1);
        $this->dibayar = $this->biayaPendaftaran;
        $this->kembalian = 0;
        $this->formcheckout = true;
    }


    public function updatingDiBayar($value)
    {
        $this->kembalian = (($value - $this->biayaPendaftaran) + $this->discount);
    }

    public function updatingDiscount($value)
    {
        $this->kembalian = (($this->dibayar - $this->biayaPendaftaran) + $value);
    }

    public function clear()
    {
        $this->reset('member', 'discount', 'simpansisa', 'formcheckout', 'dibayar', 'kembalian', 'notice');
    }


    public function submit()
    {
        $this->validate([
            'dibayar' => 'required|numeric',
        ]);
        sleep(1);

        $transaction = Transaction::create([
            'customers' => json_encode($this->member),
            'user_id' => auth()->id(),
            'amount' => $this->biayaPendaftaran,
            'discount' => $this->discount,
            'total' => ($this->biayaPendaftaran - $this->discount),
            'paid' => ($this->dibayar),
            'paid_status' => 'fullypaid',
            'type' => 'new_member',
            'notice' => $this->notice,
        ]);
        $member  = Member::create($this->member->toArray());
        if ($this->simpansisa) {
            if ($this->dibayar > $this->biayaPendaftaran || $this->kembalian > 0) {
                Simpanan::create([
                    'f_name' =>  $this->member['first_name'],
                    'l_name' =>  $this->member['last_name'],
                    'amount' => (($this->dibayar - $this->biayaPendaftaran) + $this->discount)
                ]);
            }
        }
        event(new AfterNewMember($member));
        $this->clear();
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Menambahkan Member Baru',
            'icon'        => 'success',
            'onClose' => [
                'method' => 'redirectInfoTransaksi',
                'params' => $transaction->id,
            ],
            'onDismiss' => [
                'method' => 'redirectInfoTransaksi',
                'params' => $transaction->id,
            ],
            'onTimeout' => [
                'method' => 'redirectInfoTransaksi',
                'params' => $transaction->id,
            ],
        ]);


        $this->mount();
    }
}
