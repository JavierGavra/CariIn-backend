<?php

namespace App\Http\Resources\Job;

use App\Helpers\AppFunction;
use App\Http\Resources\Tag\TagResource;
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
            'cover_image' => $this->cover_image,
            'description' => $this->description,
            'salary' => $this->salary,
            'tags' => TagResource::collection($this->tags),
            'company' => [
                'id' => $this->company->id,
                'name' => $this->company->name,
                'location' => $this->company->location,
            ],
            'expired_date' => $this->expired_date,
            'pkl_status' => AppFunction::booleanResponse($this->pkl_status),
            'confirmed_status' => $this->confirmed_status,
            'created_at' => $this->created_at,
        ];
    }
}
