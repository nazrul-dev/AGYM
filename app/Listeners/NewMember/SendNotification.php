<?php

namespace App\Listeners\NewMember;

use App\Events\AfterNewMember;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendNotification
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
        //
    }
}
