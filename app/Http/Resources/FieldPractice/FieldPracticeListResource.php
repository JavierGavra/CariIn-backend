<?php

namespace App\Http\Resources\FieldPractice;

use App\Http\Resources\Worker\WorkerListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldPracticeListResource extends JsonResource
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
                'cover_image' => $this->job->cover_image,
            ],
            'worker' => new WorkerListResource($this->worker),
            'confirmed_status' => $this->confirmed_status,
            'created_at' => $this->created_at,
        ];
    }
}
