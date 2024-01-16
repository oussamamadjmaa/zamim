<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $subscriberType = explode('\\', $this->subscriber_type);
        $subscriberType = strtolower(end($subscriberType));

        return [
            'id' => $this->id,
            'subscriberType' => $subscriberType,
            'subscriberId' => $this->subscriber_id,
            'subscriber' => $this->when($this->relationLoaded('subscriber'), fn() => [
                'id' => $this->subscriber->id,
                'name' => $this->subscriber->name,
            ]), //Relationship
            'status' => $this->getSubscriptionStatus(),
            'statusText' => __(ucfirst($this->getSubscriptionStatus())),
            'startedAt' => hijriDate($this->started_at, 'd F Y'),
            'endsAt' => hijriDate($this->ends_at, 'd F Y'),
            'canceledAt' => hijriDate($this->canceled_at, 'd F Y h:i A'),
            'renewedAt' => hijriDate($this->renewed_at, 'd F Y'),
            "plan" =>  $this->when($this->relationLoaded('plan'), fn() => [
                'id' => $this->plan->id,
                'name' => __($this->plan->name),
            ]), //Relationship
        ];
    }
}
