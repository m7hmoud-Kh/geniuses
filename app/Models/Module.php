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
}
