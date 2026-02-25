<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePromoLeadRequest;
use App\Models\PromoLead;

class PromoController extends Controller
{
    public function store(StorePromoLeadRequest $request)
    {
        $base = (int) $request->input('Base', 0);
        $extra = (int) $request->input('Extra', 0);
        $sum = max(0, $base) + max(0, $extra);
        $discountPercent = 15;
        $discountAmount = (int) round($sum * ($discountPercent / 100));
        $total = $sum - $discountAmount;

        PromoLead::create([
            'name' => $request->string('Name'),
            'phone' => $request->string('Phone'),
            'email' => $request->string('Email')->toString() ?: null,
            'model' => $request->string('Model')->toString() ?: null,
            'message' => $request->string('Message')->toString() ?: null,
            'base_price' => $base,
            'extra_price' => $extra,
            'discount_percent' => $discountPercent,
            'discount_amount' => $discountAmount,
            'total_after_discount' => $total,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'ok' => true,
            'discount_percent' => $discountPercent,
            'discount_amount' => $discountAmount,
            'total' => $total,
        ]);
    }
}
