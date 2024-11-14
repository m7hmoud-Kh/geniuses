<?php

namespace App\Models;

use App\Services\Utils\Getterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fqa extends Model
{
    use HasFactory, Getterable;
    protected $guarded = [];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
