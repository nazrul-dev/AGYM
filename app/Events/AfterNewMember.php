<?php

namespace App\Events;

use App\Models\Member;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AfterNewMember
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $member;


    public function __construct(Member $member)
    {

       $this->member = $member;
    }

}
