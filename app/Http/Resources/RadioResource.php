<?php

namespace App\Http\Resources;

use Alkoumi\LaravelHijriDate\Hijri;
use Carbon\Carbon;
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
            'teacherId' => $this->teacher_id,
            "teacher" => $this->when($this->relationLoaded('teacher'), fn() => $this->teacher), //Relationship
            'class' => $this->class,
            'radioDate' => $this->radio_date->format('Y-m-d'),
            'radioDateHijri' => hijriDate($this->radio_date, 'Y/m/d'),
            'radioDay' => $this->radio_date->translatedFormat('l'),
            "students" => $this->when($this->relationLoaded('students'), fn() => $this->students), //Relationship
            "weekNumber" => $this->radio_date->diffInWeeks(getCurrentSemester()->start_date)+1
        ];
    }
}
