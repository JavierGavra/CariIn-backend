<?php

namespace App\Http\Resources\FieldPractice;

use App\Http\Resources\Worker\WorkerListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FieldPracticeDetailResource extends JsonResource
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
                'location' => $this->job->location,
                'company' => [
                    'id' => $this->job->company->id,
                    'name' => $this->job->company->name,
                    'location' => $this->job->company->location,
                ],
            ],
            'worker' => new WorkerListResource($this->worker),
            'cv_file' => $this->cv_file,
            'portfolio_file' => $this->portfolio_file,
            'application_letter_file' => $this->application_letter_file,
            'student_evidence_file' => $this->student_evidence_file,
            'educational_institution' => $this->educational_institution,
            'description' => $this->description,
            'confirmed_status' => $this->confirmed_status,
            'created_at' => $this->created_at,
        ];;
    }
}
