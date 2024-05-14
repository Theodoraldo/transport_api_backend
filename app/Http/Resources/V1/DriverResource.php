<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'firstName' => $this->firstname,
            'lastName' => $this->lastname,
            'fullName' => $this->firstname . ' ' . $this->lastname,
            'identityType' => $this->identity_type,
            'identityNumber' => $this->identity_number,
            'phoneNumber' => $this->phone_number,
            'address' => $this->address,
        ];
    }
}
