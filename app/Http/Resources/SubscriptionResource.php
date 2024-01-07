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
            'startedAt' => $this->started_at?->translatedFormat('d M Y'),
            'endsAt' => $this->ends_at?->translatedFormat('d M Y'),
            'canceledAt' => $this->canceled_at?->translatedFormat('d M Y h:i A'),
            'renewedAt' => $this->renewed_at?->translatedFormat('d M Y'),
            "plan" =>  $this->when($this->relationLoaded('plan'), fn() => [
                'id' => $this->plan->id,
                'name' => __($this->plan->name),
            ]), //Relationship
        ];
    }
}
