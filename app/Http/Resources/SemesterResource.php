<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SemesterResource extends JsonResource
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
            'name' => $this->name,
            'startDate' => $this->start_date->format('Y-m-d'),
            'startDateFormated' => hijriDate($this->start_date, 'j F , Y'),
            'endDate' => $this->end_date->format('Y-m-d'),
            'endDateFormated' => hijriDate($this->end_date, 'j F , Y'),
            'isCurrent' => now()->between($this->start_date, $this->end_date),
        ];
    }
}
