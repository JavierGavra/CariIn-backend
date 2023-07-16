<?php

namespace App\Http\Resources\Job;

use App\Helpers\AppFunction;
use App\Http\Resources\Tag\TagResource;
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
            'title' => $this->title,
            'gender' => $this->gender,
            'company_name' => $this->company->name,
            'company_location' => $this->company->location,
            'job_created' => $this->created_at,
            'time_type' => $this->time_type,
            'salary' => $this->salary,

            'description' => [
                'description' => $this->description,
                'time_type' => $this->time_type,
                'title' => $this->title,
                'salary' => $this->salary,
                'education' => $this->education,
                'minimum_age' => $this->minimum_age,
                'maximum_age' => $this->maximum_age,
                'tags' => TagResource::collection($this->tags),
            ],

            'company' => [
                'id' => $this->company->id,
                'url' => $this->company->url,
                'location' => $this->company->location,
                'founding_date' => $this->company->founding_date,
                'employees' => $this->company->employees,
            ],

            'location' => [
                'location' => $this->location
            ],
            
            'pkl_status' => AppFunction::booleanResponse($this->pkl_status),
            'confirmed_status' => $this->confirmed_status,
        ];
    }
}
