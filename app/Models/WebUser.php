<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TripInfo;
use Parental\HasParent;

class WebUser extends User
{
    use HasParent, HasFactory;

    public function tripInfos() : HasMany
    {
        return $this->hasMany(TripInfo::class);
    }
}