<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
class Admin extends Authenticatable implements JWTSubject{
    use HasFactory, HasRoles;
    protected $guarded = [];
    protected $hidden = [
        'password'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function getCreatedAtAttribute()
    {

        $created_at = $this->attributes['created_at'] ? new DateTime($this->attributes['created_at']) : null;
        return $created_at ? $created_at->format('Y m-d h:i:s') : null;

    }
    public function getEmailVerifiedAtAttribute()
    {
        $email_verified_at = $this->attributes['email_verified_at'] ? new DateTime($this->attributes['email_verified_at']) : null;
        return $email_verified_at ? $email_verified_at->format('Y m-d h:i:s') : null;
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
}
