<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\V1\UserResource;

class TripInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "quantitySold" => $this->quantity_sold,
            "fare" => $this->fare,
            "completed" => $this->completed,
            "tripFrom" => $this->trip_from,
            "tripTo" => $this->trip_to,
            "tripTime" => $this->trip_time,
            "tripDate" => $this->trip_date,
            "duration" => $this->duration,
            "mode" => $this->mode,
            "webUser" => new UserResource($this->whenLoaded('webUser')),
            "car" => new CarResource($this->whenLoaded('car')),
            "driver" => new DriverResource($this->whenLoaded('driver')),

            //// this optional method also works....
            // "webUser" => optional($this->webUser)->exists ? new UserResource($this->webUser) : null,
            // "car" => optional($this->car)->exists ? new CarResource($this->car) : null,
            // "driver" => optional($this->driver)->exists ? new DriverResource($this->driver) : null,
        ];
    }
}
