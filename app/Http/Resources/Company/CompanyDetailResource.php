<?php

namespace App\Http\Resources\Company;

use App\Http\Resources\Job\JobListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyDetailResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'profile_image' => $this->profile_image,
            'founding_date' => $this->founding_date,
            'user_type' => $this->user_type,
            'location' => $this->location,
            'description' => $this->description,
            'outside_image' => $this->outside_image,
            'inside_image' => $this->inside_image,
            'url' => $this->url,
            'employees' => $this->employees,
            'confirmed_status' => $this->confirmed_status,
            'role' => $this->role,
            'created_at' => $this->created_at,
            'jobs' => JobListResource::collection($this->jobs),
        ];
    }
}
