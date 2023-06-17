<?php

namespace App\Http\Resources\Worker;

use App\Helpers\AppFunction;
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
            'description' => $this->description,
            'salary' => $this->salary,
            'company' => [
                'id' => $this->company->id,
                'name' => $this->company->name,
                'location' => $this->company->location,
            ],
            'pkl_status' => AppFunction::booleanResponse($this->pkl_status),
            'confirmed_status' => $this->confirmed_status,
            'created_at' => $this->created_at,
        ];
    }
}
