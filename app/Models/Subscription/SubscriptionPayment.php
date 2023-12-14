<?php

namespace App\Models\Subscription;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubscriptionPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'plan_id',
        'payment_method',
        'amount',
        'currency',
        'subscription_interval',
        'subscription_period',
        'billed_at',
        'paid_at',
        'confirmed_at',
        'canceled_at',
        'comment',
    ];

    protected $dates = [
        'billed_at',
        'paid_at',
        'confirmed_at',
        'canceled_at'
    ];

    public function payer() : MorphTo {
        return $this->morphTo();
    }

    public function plan() : BelongsTo {
        return $this->belongsTo(Plan::class);
    }


    public function pay($comment = null, ?Carbon $date = null) {
        $this->fill(['paid_at' => $date ?: now()]);
        if($comment) $this->fill(['comment' => $comment]);
        $this->save();
        return $this;
    }

    public function confirm($comment = null, ?Carbon $date = null) {
        $this->fill(['confirmed_at' => $date ?: now()]);
        if($comment) $this->fill(['comment' => $comment]);
        $this->save();
        return $this;
    }

    public function cancel($comment = null, ?Carbon $date = null) {
        $this->fill(['canceled_at' => $date ?: now()]);
        if($comment) $this->fill(['comment' => $comment]);
        $this->save();
        return $this;
    }

    public function isPaid() {
        return ! is_null($this->paid_at);
    }

    public function isConfirmed() {
        return ! is_null($this->confirmed_at);
    }

    public function isCanceled() {
        return ! is_null($this->canceled_at);
    }

}
