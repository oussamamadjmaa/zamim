<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'author' => $this->when($this->relationLoaded('author'), fn() => $this->author), //Relationship
            'radio' => $this->when($this->relationLoaded('radio'), fn() => $this->radio, ['id' => $this->radio_id]), //Relationship
            'title' => $this->title,
            'attachment' => ['path' => $this->attachment, 'pathUrl' => asset('storage/'.$this->attachment)],
            'isPublic' => $this->is_public,
            'isPublicText' => __($this->is_public ? 'Yes' : 'No'),
            'createdAt' => $this->created_at->translatedFormat('l, d M Y'),
        ];
    }
}
