<?php

namespace App\Http\Livewire\Members;

use App\Http\Livewire\Template;
use App\Models\Member;


class Data extends Template
{
    public $minfo = false;
    public $member = [];
    public $mCheckout = false;
    public function info(Member $member)
    {
        $this->minfo = true;
        $this->member = $member;
    }
    public function delete(Member $member)
    {
        $member->subscription()->delete();
        $member->delete();
        $this->notification()->notify([
            'title'       => 'Sukses',
            'description' => 'Member Berhasil Dihapus',
            'icon'        => 'success'
        ]);
    }
    public function render()
    {
        $members = Member::where(function ($q) {
            $q->where('first_name', 'like', '%' . $this->searchTerm . '%');
            $q->orWhere('last_name', 'like', '%' . $this->searchTerm . '%');
            $q->orWhere('email', 'like', '%' . $this->searchTerm . '%');
        })->latest()->paginate(20);
        return view('livewire.members.data', compact('members'));
    }
}
