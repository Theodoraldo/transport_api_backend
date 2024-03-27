<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MobileUser;
use App\Models\TripInfo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    public $fillable = ['quantity_purchased','bored', 'mobile_user_id', 'trip_info_id'];

    protected static function boot()
    {
        parent::boot();

        static::saved(function ($booking) {
            $tripInfo = $booking->tripInfo;
            if ($tripInfo) {
                $tripInfo->updateQuantitySold($booking->quantity_purchased);
            }
        });

        static::deleted(function ($booking) {
            $tripInfo = $booking->tripInfo;
            if ($tripInfo) {
                $tripInfo->decreaseQuantitySold($booking->quantity_purchased);
            }
        });
    }

    public function mobileUser() : BelongsTo
    {
        return $this->belongsTo(MobileUser::class);
    }

    public function tripInfo() : BelongsTo
    {
        return $this->belongsTo(TripInfo::class);
    }
}
