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
    ];

    protected $casts = [
        'price_rub' => 'integer',
        'gallery_images' => 'array',
        'specs_json'     => 'array',
        'specs'          => 'array',

        'compat_json'    => 'array',
        'compatibility'  => 'array',

        'docs_json'      => 'array',
        'docs'           => 'array',
        'documents'      => 'array',

        'images'         => 'array',
        'gallery'        => 'array',
    ];
}
