<?php

namespace App\Http\Resources\Worker;

use App\Helpers\AppFunction;
use App\Http\Resources\Education\EducationResource;
use App\Http\Resources\Experience\ExperienceListResource;
use App\Http\Resources\Skill\SkillResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkerProfileResource extends JsonResource
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
            'username' => $this->username,
            'email' => $this->email,
            'profil_image' => $this->profile_image,
            'backdrop_image' => $this->backdrop_image,
            'gender' => $this->gender,
            'phone_number' => $this->phone_number,
            'age' => AppFunction::findAge($this->born_date),
            'address' => $this->address,
            'born_date' => $this->born_date,
            'interested' => 'Programmer',
            'description' => $this->description,
            'experiences' => ExperienceListResource::collection($this->experiences),
            'educations' => EducationResource::collection($this->educations),
            'skills' => SkillResource::collection($this->skills),
            'company_visible' => AppFunction::booleanResponse($this->company_visible),
            'created_at' => $this->created_at,
        ];
    }
}
