<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Services\Utils\Getterable;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;
class User  extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, Getterable;

    public const DIR = '/assets/Users';
    public const DISK_NAME = 'user';


    protected $guarded = [];
    protected $hidden = [
        'password'
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
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

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function influencer()
    {
        return $this->belongsTo(Influencer::class);
    }

    public function mediaFirst()
    {
        return $this->morphOne(Media::class,'meddiable');
    }

}
