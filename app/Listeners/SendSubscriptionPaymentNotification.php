<?php

namespace App\Listeners;

use App\Events\SubscriptionPaymentStatus;
use App\Models\Admin;
use App\Models\Subscription\SubscriptionPayment;
use App\Notifications\SubscriptionPaymentStatusNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Log;

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

        try {
            if ($subscriptionPayment->status === SubscriptionPayment::IN_REVIEW) {
                $admins = Admin::all();

                foreach ($admins as $admin) {
                    $admin->notify(new SubscriptionPaymentStatusNotification($subscriptionPayment));
                }
            }else if(!is_null($subscriber)) {
                $subscriber->notify(new SubscriptionPaymentStatusNotification($subscriptionPayment));
            }
        } catch (\Exception $e) {
            Log::alert('فشل ارسال إشعار حالة الدفع: '. $e->getMessage());
        }
    }
}
