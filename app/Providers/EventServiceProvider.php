<?php

namespace App\Providers;

use App\Events\AfterNewMember;

use App\Listeners\NewMember\CreateSubscription;
use App\Listeners\NewMember\SendNotification as NewMemberSendNotification;
use App\Listeners\Renew\{CreateSubscriptionRenew, SendNotification};

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;


class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        AfterNewMember::class => [
            NewMemberSendNotification::class,
            CreateSubscription::class
        ],

        AfterRenew::class => [
            SendNotification::class,
            CreateSubscriptionRenew::class
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function shouldDiscoverEvents()
    {
        return true;
    }
}
