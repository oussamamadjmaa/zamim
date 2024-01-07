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
        $type = explode('\\', $this->type);
        $type = end($type);

        return [
            'id' => $this->id,
            'title' => __('notifications.'.$type.'.title'),
            'description' => __('notifications.'.$type.'.description'),
            'readAt' => $this->read_at ? Carbon::parse($this->read_at)->translatedFormat('d M Y H:i') : null,
            'createdAtForHumans' => $this->created_at->diffForHumans(),
            'createdAt' => $this->created_at->translatedFormat('d M y h:i A')
        ];
    }


}
