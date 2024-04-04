<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\TripInfo;
use Parental\HasParent;
use Laravel\Sanctum\HasApiTokens;

class WebUser extends User
{
    use HasParent, HasApiTokens;

    public function tripInfos(): HasMany
    {
        return $this->hasMany(TripInfo::class);
    }
}
