<?php

namespace App\Http\Resources\RecruitWorker\worker;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RecruitWorkerListResource extends JsonResource
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
            'reply_status' => $this->reply_status,
            'created_at' => $this->created_at,
        ];
    }
}
