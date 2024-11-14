<?php

namespace App\Models;

use App\Services\Utils\Getterable;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, Getterable;

    public const DIR = '/assets/Categories';
    public const DISK_NAME = 'category';
    protected $guarded = [];


    public function mediaFirst()
    {
        return $this->morphOne(Media::class,'meddiable');
    }

}
