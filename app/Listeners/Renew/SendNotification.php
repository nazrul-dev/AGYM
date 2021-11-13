<?php

namespace App\Listeners\Renew;

use App\Events\AfterRenew;
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
     * @param  AfterRenew  $event
     * @return void
     */
    public function handle(AfterRenew $event)
    {
        //
    }
}
