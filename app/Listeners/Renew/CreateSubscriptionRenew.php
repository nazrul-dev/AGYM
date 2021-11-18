<?php

namespace App\Listeners\Renew;

use App\Events\AfterRenew;
use App\Models\SubscriptionRenew;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CreateSubscriptionRenew
{

    public function __construct()
    {
        //
    }

    public function handle(AfterRenew $event)
    {
        $expired =  $event->data->member->subscription->expired_at;
        if ($expired >= Carbon::now()) {
            $newExpired = $expired->addDays(30);
        } else {
            $newExpired = CarbonImmutable::now()->add(30, 'day');
        }
        $exe = $event->data->member->subscription()->update([
            'expired_at' =>  $newExpired,
        ]);
        if ($exe) {
            SubscriptionRenew::create([
                'transaction_id' => $event->data->transaction->id,
                'member_subscription_id' =>  $event->data->member->subscription->id,
                'renew_start' =>  Carbon::now(),
                'renew_end' => $newExpired,
                'amount' => $event->data->transaction->amount
            ]);
        }
    }
}
