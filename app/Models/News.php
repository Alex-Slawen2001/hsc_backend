<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'slug',
        'published_at',
        'excerpt',
        'content',
        'image_path',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
