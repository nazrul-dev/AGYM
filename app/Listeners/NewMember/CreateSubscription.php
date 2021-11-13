<?php

namespace App\Listeners\NewMember;

use App\Events\AfterNewMember;
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

        $event->member->subscription()->create([
            'expired_at' => CarbonImmutable::now()->add(30, 'day')
        ]);
    }
}
