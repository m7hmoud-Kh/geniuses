<?php

namespace App\Models;

use App\Services\Utils\Getterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Influencer extends Model
{
    use HasFactory, Getterable;
    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($influencer) {
            $influencer->referal_token = Str::random(40);
        });
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }



}
