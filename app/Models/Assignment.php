<?php

namespace App\Models;

use App\Services\Utils\Getterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory, Getterable;
    public const DIR = '/assets/Assignments';
    public const DISK_NAME = 'assignment';
    protected $guarded = [];

    public function mediaFirst()
    {
        return $this->morphOne(Media::class,'meddiable');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

}
