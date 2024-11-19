<?php

namespace App\Models;

use App\Services\Utils\Getterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory, Getterable;

    public const DIR = '/assets/Questions';
    public const DISK_NAME = 'question';

    protected $guarded = [];


    public function mediaFirst()
    {
        return $this->morphOne(Media::class,'meddiable');
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }
}
