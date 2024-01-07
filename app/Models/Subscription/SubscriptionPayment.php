<?php

namespace App\Models\Subscription;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Str;

class SubscriptionPayment extends Model
{
    use HasFactory, SoftDeletes;

    const PENDING = 'pending';        // #FFD700 (Gold)
    const FAILED = 'failed';          // #FF0000 (Red)
    const CANCELED = 'canceled';      // #808080 (Gray)
    const COMPLETED = 'completed';    // #008000 (Green)
    const ON_HOLD = 'on_hold';        // #FFA500 (Orange)
    const REFUNDED = 'refunded';      // #0000FF (Blue)

    protected $fillable = [
        'transaction_id',
        'merchant_reference',
        'plan_id',
        'payment_method',
        'amount',
        'currency',
        'customer_email',
        'subscription_interval',
        'subscription_period',
        'initiated_at',
        'failed_at',
        'refunded_at',
        'canceled_at',
        'completed_at',
        'on_hold_at',
        'status',
        'comment',
    ];

    protected $dates = [
        'initiated_at',
        'failed_at',
        'refunded_at',
        'canceled_at',
        'completed_at',
        'on_hold_at',
    ];

    public function payer() : MorphTo {
        return $this->morphTo();
    }

    public function plan() : BelongsTo {
        return $this->belongsTo(Plan::class);
    }


    public function failed($comment = null, ?Carbon $date = null) {
        $this->fill(['failed_at' => $date ?: now(), 'status' => self::FAILED]);
        if($comment) $this->fill(['comment' => $comment]);
        $this->save();
        return $this;
    }

    public function refund($comment = null, ?Carbon $date = null) {
        $this->fill(['refunded_at' => $date ?: now(), 'status' => self::REFUNDED]);
        if($comment) $this->fill(['comment' => $comment]);
        $this->save();
        return $this;
    }

    public function cancel($comment = null, ?Carbon $date = null) {
        $this->fill(['canceled_at' => $date ?: now(), 'status' => self::CANCELED]);
        if($comment) $this->fill(['comment' => $comment]);
        $this->save();
        return $this;
    }

    public function complete($comment = null, ?Carbon $date = null) {
        $this->fill(['completed_at' => $date ?: now(), 'status' => self::COMPLETED]);
        if($comment) $this->fill(['comment' => $comment]);
        $this->save();
        return $this;
    }

    public function on_hold($comment = null, ?Carbon $date = null) {
        $this->fill(['on_hold_at' => $date ?: now(), 'status' => self::ON_HOLD]);
        if($comment) $this->fill(['comment' => $comment]);
        $this->save();
        return $this;
    }

    public function isPending() {
        return $this->status == self::PENDING;
    }

    public function isFailed() {
        return $this->status == self::FAILED;
    }

    public function isCanceled() {
        return $this->status == self::CANCELED;
    }

    public function isCompleted() {
        return $this->status == self::COMPLETED;
    }

    public function isOnHold() {
        return $this->status == self::ON_HOLD;
    }

    public function isRefunded() {
        return $this->status == self::REFUNDED;
    }

    //
    public function duration() {
        return $this->subscription_period == 1 ?
                __(ucfirst($this->subscription_interval)) :
                ($this->subscription_period) . " " . __(ucfirst($this->subscription_interval)."s");
    }

    public function carbonDuration() {
        return 'add'.ucfirst($this->subscription_interval).'s';
    }
    //

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payment) {
            $payment->merchant_reference = self::generateMerchantReference();
        });
    }

    private static function generateMerchantReference()
    {
        $timestamp = now()->timestamp;
        $randomNumber = Str::upper(Str::random(8));

        return 'ZAMIMSUB-' . $timestamp . '-' . $randomNumber;
    }

}
