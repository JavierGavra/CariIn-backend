<?php

namespace App\Http\Resources\JobApplication;

use App\Http\Resources\Worker\WorkerListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationDetailResource extends JsonResource
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
            'job' => $this->job == null? null : [
                'id' => $this->job->id,
                'title' => $this->job->title,
                'cover_image' => $this->job->cover_image,
                'location' => $this->job->location,
                'company' => [
                    'id' => $this->job->company->id,
                    'name' => $this->job->company->name,
                    'profile_image' => $this->job->profile_image,
                    'location' => $this->job->company->location,
                ],
            ],
            'worker' => new WorkerListResource($this->worker),
            'cv_file' => $this->cv_file,
            'description' => $this->description,
            'confirmed_status' => $this->confirmed_status,
            'created_at' => $this->created_at,
        ];
    }
}
