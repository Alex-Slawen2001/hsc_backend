<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'sku',
        'model',
        'category',
        'availability',
        'price_rub',
        'image_path',
        'gallery_images',
        'short_description',
        'description',

        // tabs
        'description_html',
        'specs_json',
        'compat_json',
        'docs_json',
    ];

    protected $casts = [
        'price_rub' => 'integer',
        'gallery_images' => 'array',

        // tabs
        'specs_json' => 'array',
        'compat_json' => 'array',
        'docs_json' => 'array',
    ];
}
