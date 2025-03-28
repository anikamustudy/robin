<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipNotificationResource extends JsonResource
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
            'membership_request' => new MembershipRequestResource($this->whenLoaded('membershipRequest')),
            'user' => new UserResource($this->whenLoaded('user')),
            'type' => $this->type,
            'message' => $this->message,
            'sentAt' => $this->sent_at,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
