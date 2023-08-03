<?php

namespace App\Http\Resources\RecruitWorker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecruitWorkerDetailResource extends JsonResource
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
            'worker' => [
                'id' => $this->worker->id,
                'username' => $this->worker->username,
                'profile_image' => $this->worker->profile_image,
            ],
            'job' => [
                'id' => $this->job->id,
                'title' => $this->job->title,
            ],
            'description' => $this->description,
            'worker_message' => $this->worker_message,
            'reply_status' => $this->reply_status,
            'created_at' => $this->created_at,
        ];
    }
}
