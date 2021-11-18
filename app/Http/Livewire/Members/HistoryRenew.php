<?php

namespace App\Http\Livewire\Members;

use App\Http\Livewire\Template;
use App\Models\Member;
use App\Models\SubscriptionRenew;

class HistoryRenew extends Template
{
    public Member $member;
    public function render()
    {
        $data = SubscriptionRenew::where('member_subscription_id', $this->member->subscription->id)->latest()->paginate(10);

        return view('livewire.members.history-renew', compact('data'));
    }
}
