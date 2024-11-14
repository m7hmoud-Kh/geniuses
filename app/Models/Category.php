<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    public const DIR = '/assets/Categories';
    public const DISK_NAME = 'category';
    protected $guarded = [];


    public function mediaFirst()
    {
        return $this->morphOne(Media::class,'meddiable');
    }

    public function getCreatedAtAttribute()
    {

        $created_at = $this->attributes['created_at'] ? new DateTime($this->attributes['created_at']) : null;
        return $created_at ? $created_at->format('Y m-d h:i:s') : null;
    }

}
