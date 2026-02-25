<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromoLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'model',
        'message',
        'base_price',
        'extra_price',
        'discount_percent',
        'discount_amount',
        'total_after_discount',
        'ip',
        'user_agent',
    ];

    protected $casts = [
        'base_price' => 'integer',
        'extra_price' => 'integer',
        'discount_percent' => 'integer',
        'discount_amount' => 'integer',
        'total_after_discount' => 'integer',
    ];
}
