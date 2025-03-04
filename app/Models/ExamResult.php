<?php

namespace App\Models;

use App\Services\Utils\Getterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamResult extends Model
{
    use HasFactory, Getterable;
    protected $guarded = [];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
