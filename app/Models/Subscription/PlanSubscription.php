<?php

namespace App\Models\Subscription;

use App\Models\Traits\Searchable;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanSubscription extends Model
{
    use HasFactory, SoftDeletes, Searchable;

    protected $fillable = [
        'plan_id',
        'started_at',
        'ends_at',
        'renewed_at',
        'canceled_at'
    ];

    protected $dates = [
        'started_at',
        'ends_at',
        'renewed_at',
        'canceled_at'
    ];

    public function subscriber() : MorphTo {
        return $this->morphTo();
    }

    public function plan() : BelongsTo {
        return $this->belongsTo(Plan::class);
    }

    public function scopeActive($q) {
        return $q->whereNull('canceled_at')->whereDate('ends_at', '>=', now());
    }

    public function cancel(?Carbon $date = null) {
        $this->fill(['canceled_at' => $date ?: Carbon::now()]);
        $this->save();
        return $this;
    }

    public function isActive() {
        return Carbon::now()->gte($this->started_at) && !is_null($this->ends_at) && !$this->isCanceled() && !$this->isExpired();
    }

    public function isRenew() {
        return !is_null($this->renewed_at);
    }

    public function isExpired() {
        return Carbon::now()->gte($this->ends_at) || is_null($this->ends_at);
    }

    public function isCanceled() {
        return $this->canceled_at ? Carbon::now()->gte($this->canceled_at) : false;
    }

    public function getSubscriptionStatus() {
        return $this->isCanceled() ? 'canceled' : ($this->isExpired() ? 'expired' : ($this->isActive() ? 'active' : 'unknown'));
    }

    protected function searchColumns() {
        return [
            'subscriber' => [
                'id',
                'name',
                'email'
            ]
        ];
    }

}
