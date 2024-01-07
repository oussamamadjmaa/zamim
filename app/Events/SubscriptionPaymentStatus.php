<?php

namespace App\Events;

use App\Models\Subscription\SubscriptionPayment;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SubscriptionPaymentStatus
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $subscriptionPayment;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(SubscriptionPayment $subscriptionPayment)
    {
        $this->subscriptionPayment = $subscriptionPayment;
    }

}
