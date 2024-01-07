<?php

namespace App\Listeners;

use App\Events\SubscriptionPaymentStatus;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendSubscriptionPaymentNotification
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(SubscriptionPaymentStatus $event)
    {
        $subscriptionPayment = $event->subscriptionPayment;
        $subscriber = $subscriptionPayment->payer;

        if(!is_null($subscriber)) {
            // $subscriber->notify(new NotificationsSubscriptionPaymentConfirmed($subscriptionPayment));
        }
    }
}
