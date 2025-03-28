<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankResource extends JsonResource
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
            'bank_type' => new BankTypeResource($this->whenLoaded('bankType')),
            'user' => new UserResource($this->whenLoaded('user')),
            'bankName' => $this->name,
            'bankAddress' => $this->address,
            'branches' => BranchResource::collection($this->whenLoaded('branches')),
            'staff' => BankStaffResource::collection($this->whenLoaded('staff')),
            'valuers' => ValuerResource::collection($this->whenLoaded('valuers')),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
