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
            // "subscriptionInterval" => $this->subscription_interval,
            // "subscriptionPeriod" => $this->subscription_period,
            "subscriptionPeriodText" => $this->duration(),
            "createdAt" => $this->when(!is_null($this->created_at), fn() => $this->created_at->translatedFormat("d M Y H:i")),
            "updatedAt" => $this->when(!is_null($this->created_at), fn() => $this->created_at->translatedFormat("d M Y H:i")),
            "initiatedAt" => $this->when(!is_null($this->initiated_at), fn() => $this->initiated_at->translatedFormat("d M Y H:i")),
            "failedAt" => $this->when(!is_null($this->failed_at), fn() =>  $this->failed_at->translatedFormat("d M Y H:i")),
            "refundedAt" => $this->when(!is_null($this->refunded_at), fn() => $this->refunded_at->translatedFormat("d M Y H:i")),
            "canceledAt" => $this->when(!is_null($this->canceled_at), fn() => $this->canceled_at->translatedFormat("d M Y H:i")),
            "completedAt" => $this->when(!is_null($this->completed_at), fn() => $this->completed_at->translatedFormat("d M Y H:i")),
            "onHoldAt" => $this->when(!is_null($this->on_hold_at), fn() => $this->on_hold_at->translatedFormat("d M Y H:i")),
            "status" => $this->status,
            "statusText" => __(ucfirst(str_replace('_', ' ', $this->status))),
            "comment" => $this->comment,

        ];

        return $data;
    }
}
