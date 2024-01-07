<?php

namespace App\Observers;

use App\Events\SubscriptionPaymentStatus;
use App\Models\Subscription\SubscriptionPayment;
use Log;

class SubscriptionPaymentObserver
{
    /**
     * Handle the SubscriptionPayment "created" event.
     *
     * @param  \App\Models\Subscription\SubscriptionPayment $subscriptionPayment
     * @return void
     */
    public function created(SubscriptionPayment $subscriptionPayment)
    {

    }

    /**
     * Handle the SubscriptionPayment "updated" event.
     *
     * @param  \App\Models\Subscription\SubscriptionPayment $subscriptionPayment
     * @return void
     */
    public function updated(SubscriptionPayment $subscriptionPayment)
    {
        if($subscriptionPayment->wasChanged('status')) {
            //If payment completed
            if ($subscriptionPayment->isCompleted() && $subscriptionPayment->getOriginal('status') != SubscriptionPayment::CANCELED) {
                $subscriber = $subscriptionPayment->payer;
                $endsAt = $this->calculateSubscriptionEndDate($subscriptionPayment);
                $subscription = $this->updateOrCreateSubscription($subscriber, $subscriptionPayment, $endsAt);
            }

            event(new SubscriptionPaymentStatus($subscriptionPayment));
        }
    }

    /**
     * Handle the SubscriptionPayment "deleted" event.
     *
     * @param  \App\Models\Subscription\SubscriptionPayment $subscriptionPayment
     * @return void
     */
    public function deleted(SubscriptionPayment $subscriptionPayment)
    {
        //
    }

    /**
     * Handle the SubscriptionPayment "restored" event.
     *
     * @param  \App\Models\Subscription\SubscriptionPayment $subscriptionPayment
     * @return void
     */
    public function restored(SubscriptionPayment $subscriptionPayment)
    {
        //
    }

    /**
     * Handle the SubscriptionPayment "force deleted" event.
     *
     * @param  \App\Models\Subscription\SubscriptionPayment $subscriptionPayment
     * @return void
     */
    public function forceDeleted(SubscriptionPayment $subscriptionPayment)
    {
        //
    }


    protected function calculateSubscriptionEndDate(SubscriptionPayment $subscriptionPayment)
    {
        $endsAt = now()->{$subscriptionPayment->carbonDuration()}($subscriptionPayment->subscription_period);

        if ($subscription = $subscriptionPayment->payer->subscription) {
            if ($subscription->ends_at->gt(now())) {
                $endsAt = $subscription->ends_at->{$subscriptionPayment->carbonDuration()}($subscriptionPayment->subscription_period);
            }
        }

        return $endsAt;
    }

    protected function updateOrCreateSubscription($subscriber, SubscriptionPayment $subscriptionPayment, $endsAt)
    {
        $subscriptionAttributes = [
            'plan_id' => $subscriptionPayment->plan_id,
            'started_at' => now(),
            'ends_at' => $endsAt
        ];

        if ($subscriber->subscription) {
            $subscriber->subscription()->update(array_merge($subscriptionAttributes, ['renewed_at' => now()]));
        } else {
            $subscriber->subscription()->create($subscriptionAttributes);
        }

        return $subscriber->subscription;
    }
}
