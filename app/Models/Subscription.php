<?php

namespace App\Models;

use App\Services\Utils\Getterable;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory, Getterable;
    protected $guarded = [];

    public function getStartDateAttribute()
    {
        $created_at = $this->attributes['start_date'] ? new DateTime($this->attributes['start_date']) : null;
        return $created_at ? $created_at->format('Y m-d h:i:s') : null;
    }


    public function getEndDateAttribute()
    {
        $created_at = $this->attributes['end_date'] ? new DateTime($this->attributes['end_date']) : null;
        return $created_at ? $created_at->format('Y m-d h:i:s') : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
