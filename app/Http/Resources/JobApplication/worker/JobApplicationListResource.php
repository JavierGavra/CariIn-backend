<?php

namespace App\Http\Resources\JobApplication\worker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobApplicationListResource extends JsonResource
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
            'job' => [
                'id' => $this->job->id,
                'title' => $this->job->title,
            ],
            'worker' => [
                'id' => $this->worker->id,
                'username' => $this->worker->username,
            ],
            'confirmed_status' => $this->confirmed_status,
            'created_at' => $this->created_at,
        ];
    }
}