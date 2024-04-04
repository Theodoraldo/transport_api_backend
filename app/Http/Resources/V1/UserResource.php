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
            'name' => $this->name,
            'email' => $this->email,
            'image' => $this->image,
            'cellPhone' => $this->cellphone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'identityCard' => $this->identity_card,
            'cardNumber' => $this->card_number,
        ];
    }
}
