<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RadioResource extends JsonResource
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
            'radioDate' => $this->radio_date->format('Y-m-d'),
            'radioDateFormated' => $this->radio_date?->translatedFormat('d M Y'),
            'radioDay' => $this->radio_date->translatedFormat('l'),
            'students' => $this->students
        ];
    }
}
