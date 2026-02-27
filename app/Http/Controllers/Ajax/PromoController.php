<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'phone' => ['nullable','string','max:255'],
            'email' => ['nullable','email','max:255'],
            'message' => ['nullable','string','max:5000'],
        ]);

        Inquiry::create([
            'message' => "Промо/калькулятор:\n" . ($data['message'] ?? ''),
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'company' => null,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'ok' => true,
            'message' => 'Заявка отправлена! Мы свяжемся с вами в ближайшее время.',
        ]);
    }
}
