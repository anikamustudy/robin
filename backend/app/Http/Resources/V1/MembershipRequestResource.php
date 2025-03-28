<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MembershipRequestResource extends JsonResource
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
            'email' => $this->email,
            'name' => $this->name,
            'role' => $this->role,
            'bank' => new BankResource($this->whenLoaded('bank')),
            'branch' => new BranchResource($this->whenLoaded('branch')),
            'valuer' => new ValuerResource($this->whenLoaded('valuer')),
            'status' => $this->status,
            'reason' => $this->reason,
            'tempPassword' => $this->temp_password,
            'requestedAt' => $this->requested_at,
            'reviewedAt' => $this->reviewed_at,
            'reviewedBy' => new UserResource($this->whenLoaded('reviewer')),
            'notifications' => MembershipNotificationResource::collection($this->whenLoaded('notifications')),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
