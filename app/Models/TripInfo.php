<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Car;
use App\Models\Driver;  
use App\Models\WebUser;
use App\Models\Booking;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TripInfo extends Model
{
    use HasFactory;

    public function booking() : HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function car() : BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function driver() : BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }

    public function webUser() : BelongsTo
    {
        return $this->belongsTo(WebUser::class);
    }
}
