<?php

namespace App\Http\Resources\RecruitWorker\worker;

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
