<?php

namespace App\Http\Resources\Worker;

use App\Helpers\AppFunction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkerDetailResource extends JsonResource
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
            'gender' => $this->gender,
            'age' => AppFunction::findAge($this->born_date),
            'address' => $this->address,
            'born_date' => $this->born_date,
            'interested' => 'Programmer',
            'description' => $this->description,
            'created_at' => $this->created_at,
        ];
    }
}
