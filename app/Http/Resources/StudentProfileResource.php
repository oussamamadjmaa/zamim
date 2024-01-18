<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentProfileResource extends JsonResource
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
            'parentName' => $this->parent_name,
            'parentEmail' => $this->parent_email,
            'level' => $this->level,
            'levelText' => __(ucfirst($this->level)),
            'class' => $this->class,
            'division' => $this->division,
        ];
    }
}
