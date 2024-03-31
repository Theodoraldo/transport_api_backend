<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Booking;
use Laravel\Sanctum\HasApiTokens;
use Parental\HasParent;

class MobileUser extends User
{
    use HasParent, HasApiTokens;

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
