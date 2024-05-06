<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RadioWeekResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $startDate = Carbon::parse($this->start_date)->format('Y-m-d');
        $endDate = Carbon::parse($this->end_date)->format('Y-m-d');
        return [
            "semesterId" => $this->semester_id,
            "semester" => $this->when($this->relationLoaded('semester'), fn() => [
                'id' => $this->semester->id,
                'name' => $this->semester->name
            ]), //Relationship
            'level' => $this->level,
            'levelText' => __(ucfirst($this->level)),
            'weekNumberEn' => $this->week_number,
            'weekNumber' => transNumber($this->week_number),
            'startDate' => $startDate,
            'startDateHijri' => hijriDate($startDate, 'Y/m/d'),
            'endDate' => $endDate,
            'endDateHijri' => hijriDate($endDate, 'Y/m/d'),
        ];
    }
}
