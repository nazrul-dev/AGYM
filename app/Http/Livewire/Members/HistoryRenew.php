<?php

namespace App\Http\Livewire\Members;

use App\Http\Livewire\Template;
use App\Models\Member;


class HistoryRenew extends Template
{
    public Member $member;
    public function render()
    {

        $data = $this->member->subscription->renews()->paginate(10);

        return view('livewire.members.history-renew', compact('data'));
    }
}
