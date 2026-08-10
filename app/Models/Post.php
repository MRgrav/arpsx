<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'title',
        'image',
        'images',
        'content',
        'video',
        'videos',
    ];

    protected $casts = [
        'images' => 'array',
        'videos' => 'array',
    ];

}
