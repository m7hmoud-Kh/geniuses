<?php

namespace App\Models;

use App\Services\Utils\Getterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    use HasFactory, Getterable;
    protected $guarded = [];

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
