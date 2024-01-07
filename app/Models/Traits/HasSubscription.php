<?php

namespace App\Models\Traits;

use App\Models\Subscription\PlanSubscription;
use App\Models\Subscription\SubscriptionPayment;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasSubscription {
    public function subscription() : MorphOne {
        return $this->morphOne(PlanSubscription::class, 'subscriber');
    }

    public function subscription_payments() {
        return $this->morphMany(SubscriptionPayment::class, 'payer');
    }
}
