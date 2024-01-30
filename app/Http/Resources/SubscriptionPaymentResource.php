<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Storage;

class SubscriptionPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            "id" => $this->id,
            "payer" => $this->when($this->relationLoaded('payer'), fn() => [
                'id' => $this->payer->id,
                'name' => $this->payer->name,
                'email' => $this->payer->email,
            ]), //Relationship
            "planId" => $this->plan_id,
            "plan" =>  $this->when($this->relationLoaded('plan'), fn() => [
                'id' => $this->plan->id,
                'name' => __($this->plan->name),
            ]), //Relationship
            "paymentMethod" => $this->payment_method,
            "paymentMethodText" => __(config('payment-methods.'.$this->payment_method.'.title')),
            "amount" => number_format($this->amount),
            "currency" => $this->currency,
            "currencyText" => __($this->currency),
            "receipt" => $this->when($this->payment_method == 'bank_transfer' && $this->relationLoaded('receipt'), fn() => asset('storage/'. $this->receipt->path) ),
            // "subscriptionInterval" => $this->subscription_interval,
            // "subscriptionPeriod" => $this->subscription_period,
            "subscriptionPeriodText" => $this->duration(),
            "createdAt" => $this->when(!is_null($this->created_at), fn() => hijriDate($this->created_at, "d F Y H:i")),
            "updatedAt" => $this->when(!is_null($this->created_at), fn() => hijriDate($this->created_at, "d F Y H:i")),
            "initiatedAt" => $this->when(!is_null($this->initiated_at), fn() => hijriDate($this->initiated_at, "d F Y H:i")),
            "failedAt" => $this->when(!is_null($this->failed_at), fn() =>  hijriDate($this->failed_at, "d F Y H:i")),
            "refundedAt" => $this->when(!is_null($this->refunded_at), fn() => hijriDate($this->refunded_at, "d F Y H:i")),
            "canceledAt" => $this->when(!is_null($this->canceled_at), fn() => hijriDate($this->canceled_at, "d F Y H:i")),
            "completedAt" => $this->when(!is_null($this->completed_at), fn() => hijriDate($this->completed_at, "d F Y H:i")),
            "onHoldAt" => $this->when(!is_null($this->on_hold_at), fn() => hijriDate($this->on_hold_at, "d F Y H:i")),
            "status" => $this->status,
            "statusText" => __(ucfirst(str_replace('_', ' ', $this->status))),
            "comment" => $this->comment,

        ];

        return $data;
    }
}
