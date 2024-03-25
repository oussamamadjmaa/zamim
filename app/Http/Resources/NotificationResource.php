<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => __('db_notifications.'.$this->data['notification_type'].'.title'),
            'description' => __('db_notifications.'.$this->data['notification_type'].'.description', $this->data),
            'readAt' => $this->read_at ? Carbon::parse($this->read_at)->translatedFormat('d M Y H:i') : null,
            'createdAtForHumans' => $this->created_at->diffForHumans(),
            'createdAt' => $this->created_at->translatedFormat('d M y h:i A')
        ];
    }


}
