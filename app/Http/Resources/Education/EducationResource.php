<?php

namespace App\Http\Resources\Education;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
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
            'educational_institution' => $this->educational_institution,
            'start_at' => $this->start_at,
            'end_at' => $this->end_at,
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
