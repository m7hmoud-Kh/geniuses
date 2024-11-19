<?php

namespace App\Models;

use App\Services\Utils\Getterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use HasFactory, Getterable;

    protected $guarded = [];


    public function question()
    {
        return $this->belongsTo(Question::class);
    }

}
