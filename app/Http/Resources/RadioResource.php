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
            'semesterId' => $this->semester_id,
            "semester" => $this->when($this->relationLoaded('semester'), fn() => $this->semester), //Relationship
            'level' => $this->level,
            'subject' => $this->subject,
            'radioDate' => $this->radio_date->format('Y-m-d'),
            'radioDateHijri' => hijriDate($this->radio_date, 'Y/m/d'),
            'radioDay' => $this->radio_date->translatedFormat('l'),
            "weekNumber" => $this->week_number
        ];
    }
}
