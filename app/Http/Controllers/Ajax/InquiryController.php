<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInquiryRequest;
use App\Models\Inquiry;

class InquiryController extends Controller
{
    public function store(StoreInquiryRequest $request)
    {
        Inquiry::create([
            'message' => $request->string('Message'),
            'name' => $request->string('Name'),
            'email' => $request->string('Email')->toString() ?: null,
            'phone' => $request->string('Phone')->toString() ?: null,
            'company' => $request->string('Company')->toString() ?: null,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json(['ok' => true]);
    }
}
