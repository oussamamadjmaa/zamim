<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ActivityResource extends JsonResource
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
            'schoolId' => $this->school_id,
            'teacher' => $this->teacher,
            'name' => $this->name,
            'bgImage' => ['path' => $this->bg_image, 'pathUrl' => asset('storage/'.$this->bg_image)],
            'class' => $this->class,
            'activityDate' => $this->activity_date->format('Y-m-d'),
            'activityDateFormated' => $this->activity_date?->translatedFormat('d M Y'),
            'activityDay' => $this->activity_date->translatedFormat('l'),
            'students' => $this->students
        ];
    }
}
