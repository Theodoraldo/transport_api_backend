<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Booking;
use Parental\HasParent;

class MobileUser extends User
{
    use HasParent;

    public function bookings() : HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
