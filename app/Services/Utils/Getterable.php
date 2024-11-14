<?php

namespace App\Services\Utils;

use DateTime;

trait Getterable
{

    public function getCreatedAtAttribute()
    {

        $created_at = $this->attributes['created_at'] ? new DateTime($this->attributes['created_at']) : null;
        return $created_at ? $created_at->format('Y m-d h:i:s') : null;

    }
}
