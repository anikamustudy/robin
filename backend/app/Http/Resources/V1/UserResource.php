<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'status' => $this->status,
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
            'bank' => new BankResource($this->whenLoaded('bank')),
            'valuer' => new ValuerResource($this->whenLoaded('valuer')),
            'bankStaff' => new BankStaffResource($this->whenLoaded('bankStaff')),
            'valuerStaff' => new ValuerStaffResource($this->whenLoaded('valuerStaff')),

        ];
    }
}
