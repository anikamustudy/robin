<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ValuerResource extends JsonResource
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
            'user' => new UserResource($this->whenLoaded('user')),
            'organizationName' => $this->organization_name,
            'organizationAddress' => $this->organization_address,
            'organizationContactNumber' => $this->ogranization_contact_number,
            'organizationMainPerson'=>$this->organization_main_person,
            'designation' => $this->designation,
            'organizationRegisterDate' => $this->organization_register_date,
            'staff' => ValuerStaffResource::collection($this->whenLoaded('staff')),
            'banks' => BankResource::collection($this->whenLoaded('banks')),
            'createdAt' => $this->created_at,
            'updatedAt' => $this->updated_at,
        ];
    }
}
