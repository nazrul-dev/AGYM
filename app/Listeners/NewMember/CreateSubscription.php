<?php

namespace App\Listeners\NewMember;

use App\Events\AfterNewMember;
use App\Models\MemberSubscription;
use Carbon\CarbonImmutable;

class CreateSubscription
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AfterNewMember  $event
     * @return void
     */
    public function handle(AfterNewMember $event)
    {

        MemberSubscription::updateOrCreate(
            [
                'member_id' => $event->member->id,
            ],
            [
                'member_id' => $event->member->id,
                'expired_at' => CarbonImmutable::now()->add(30, 'day')
            ]
        );
    }
}
