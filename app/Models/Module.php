<?php

namespace App\Models;

use App\Services\Utils\Getterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory, Getterable;

    public const DIR = '/assets/Modules';
    public const DISK_NAME = 'module';

    protected $guarded = [];

    public function attachments()
    {
        return $this->morphMany(Media::class,'meddiable');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function subscription()
    {
        return $this->hasMany(Subscription::class);
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}
