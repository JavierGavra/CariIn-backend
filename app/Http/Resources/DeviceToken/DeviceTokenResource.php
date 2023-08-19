<?php

namespace App\Http\Resources\DeviceToken;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DeviceTokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'device_token' => is_null($this->deviceToken)? null : $this->deviceToken->token,
        ];
    }
}
