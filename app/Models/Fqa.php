<?php

namespace App\Models;

use App\Services\Utils\Getterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fqa extends Model
{
    use HasFactory, Getterable;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
