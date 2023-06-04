<?php

namespace App\Http\Resources\Admin;

use App\Helpers\AppFunction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobDetailResource extends JsonResource
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
            'title' => $this->id,
            'city' => $this->city,
            'time_type' => $this->time_type,
            'salary' => $this->salary,
            'company' => [
                'id' => $this->company->id,
                'name' => $this->company->name,
                'location' => $this->company->location,
            ],
            'gender' => $this->gender,
            'education' => $this->education,
            'minimum_age' => $this->minimum_age,
            'maximum_age' => $this->maximum_age,
            'description' => $this->description,
            'pkl_status' => AppFunction::booleanResponse($this->pkl_status),
            'confirmed_status' => $this->confirmed_status,
            'created_at' => $this->created_at
        ];
    }
}
