<?php

namespace App\Http\Resources\Worker;

use App\Helpers\AppFunction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkerListResource extends JsonResource
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
            'profil_image' => $this->profile_image,
            'gender' => $this->gender,
            'age' => AppFunction::findAge($this->born_date),
            'address' => $this->address,
            'interested' => $this->interested,
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
