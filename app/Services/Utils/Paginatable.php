<?php

namespace App\Services\Utils;

trait paginatable
{
    public static function getPaginatable($collection)
    {
        return [
            'pagination' => [
                'path' => $collection->path(),
                'total' => $collection->total(),
                'per_page' => $collection->perPage(),
                'current_page' => $collection->currentPage(),
                'last_page' => $collection->lastPage(),
                'from' => $collection->firstItem(),
                'to' => $collection->lastItem(),
            ],
        ];
    }
}
