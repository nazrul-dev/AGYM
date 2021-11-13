<?php

namespace App\Listeners\Rent;

use App\Events\AfterRent;
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
     * @param  AfterRent  $event
     * @return void
     */
    public function handle(AfterRent $event)
    {
        //
    }
}
