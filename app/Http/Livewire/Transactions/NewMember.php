<?php

namespace App\Http\Livewire\Transactions;

use App\Events\AfterNewMember;
use App\Http\Livewire\Template;
use App\Models\Member;
use App\Models\Transaction;


class NewMember extends Template
{

    public $member;
    public $formcheckout = false;
    public $dibayar = 0, $kembalian = 0, $notice;
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

    public function checkout(){
        $this->validate();
        sleep(1);
        $this->dibayar = $this->biayaPendaftaran;
        $this->kembalian = 0;
        $this->formcheckout = true;
    }


    public function updatingDiBayar($value){


        $this->kembalian = ($value - $this->biayaPendaftaran);
    }

    public function clear(){
        $this->reset('member', 'formcheckout', 'dibayar', 'kembalian','notice');
    }


    public function submit(){
        $this->validate([
            'dibayar' => 'required|numeric',
        ]);
        sleep(1);

        Transaction::create([
            'customers' => json_encode($this->member),
            'user_id' => auth()->id(),
            'amount' => $this->biayaPendaftaran,
            'total' => $this->biayaPendaftaran,
            'paid' => $this->dibayar,
            'paid_status' => 'fullypaid',
            'type' => 'new_member',
            'notice' => $this->notice,
        ]);
        $member   = Member::create($this->member->toArray());

        $this->clear();
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Berhasil Menambahkan Member Baru',
            'icon'        => 'success'
        ]);

        event(new AfterNewMember($member));
        $this->mount();
    }
}
