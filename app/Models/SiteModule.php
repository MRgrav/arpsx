<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteModule extends Model
{
    protected $fillable = [
        'name',
        'files',
    ];

    protected $casts = [
        'files' => 'array',
    ];
}
