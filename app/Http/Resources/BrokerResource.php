<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BrokerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $this
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $fields = [
            'id' => $this->id,
            'address' => $this->address,
            'number_consultations' => $this->number_consultations,
            'info' => $this->info,
            'areas' => $this->areas,
        ];
        return $fields;
    }
}
