<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use App\Models\TripInfo;

class Car extends Model
{
    use HasFactory;

    public $fillable = ['brand', 'model', 'number_plate', 'color', 'seater'];

    public function tripInfos(): HasMany
    {
        return $this->hasMany(TripInfo::class);
    }
}
