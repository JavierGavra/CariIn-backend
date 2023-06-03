<?php

namespace App\Http\Resources\Worker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobListResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'city' => $this->city,
            'company' => [
                'id' => $this->company->id,
                'name' => $this->company->name,
                'location' => $this->company->location,
            ],
            'pkl_status' => booleanConvert($this->pkl_status),
            'confirmed_status' => $this->confirmed_status,
        ];
    }
}
