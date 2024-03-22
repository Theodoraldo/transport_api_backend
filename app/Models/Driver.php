<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    public $fillable = ['firstname', 'lastname', 'phone_number', 'identity_type', 'identity_number', 'address'];

    protected $appends = ['full_name'];

    public function getFullNameAttribute() : string
    {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function tripInfo() : HasMany
    {
        return $this->hasMany(TripInfo::class);
    }
}
