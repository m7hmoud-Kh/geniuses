<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    public const DIR = '/assets/Settings';
    public const DISK_NAME = 'setting';
    public $timestamps = false;
    protected $guarded = [];

}
