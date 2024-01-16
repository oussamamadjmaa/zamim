<?php

namespace App\Http\Resources;

use Alkoumi\LaravelHijriDate\Hijri;
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
            "teacher" => $this->when($this->relationLoaded('teacher'), fn() => $this->teacher), //Relationship
            'name' => $this->name,
            'bgImage' => ['path' => $this->bg_image, 'pathUrl' => asset('storage/'.$this->bg_image)],
            'class' => $this->class,
            'activityDate' => $this->activity_date->format('Y-m-d'),
            'activityDateFormated' => hijriDate($this->activity_date),
            'activityDay' => $this->activity_date->translatedFormat('l'),
            "students" => $this->when($this->relationLoaded('students'), fn() => $this->students), //Relationship
        ];
    }
}
