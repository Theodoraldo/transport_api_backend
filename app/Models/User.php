<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Parental\HasChildren;
use App\Models\MobileUser;
use App\Models\WebUser;

class User extends Authenticatable
{
    use HasApiTokens, HasChildren;

    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'type',
        'cellphone',
        'image',
        'address',
        'city',
        'state',
        'identity_card',
        'card_number',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected $childTypes = [
        'web' => WebUser::class,
        'mobile' => MobileUser::class,
    ];
}
