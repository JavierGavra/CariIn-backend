<?php

namespace App\Http\Resources\Experience;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceDetailResource extends JsonResource
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
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'location' => $this->location,
            'description' => $this->description,
            'proof_image' => $this->proof_image,
            'created_at' => $this->created_at,
        ];
    }
}
