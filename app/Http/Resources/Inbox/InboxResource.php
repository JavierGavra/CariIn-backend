<?php

namespace App\Http\Resources\Inbox;

use App\Helpers\AppFunction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InboxResource extends JsonResource
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
            'subject' => $this->subject,
            'message' => $this->message,
            'sent_date' => $this->created_at,
            'read' => AppFunction::booleanResponse($this->read),
            'type' => $this->type,
            'redirect_id' => $this->redirect_id
        ];
    }
}
