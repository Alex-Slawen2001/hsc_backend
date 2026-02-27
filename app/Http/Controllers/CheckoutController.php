<?php

namespace App\Http\Controllers;

use App\Models\Inquiry;
use App\Services\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'comment' => ['nullable', 'string', 'max:5000'],
        ]);

        $cart = Cart::detailed();
        $lines = $cart['lines'] ?? [];
        if (!is_array($lines) || !count($lines)) {
            return redirect('/cart')->with('ok', 'Корзина пуста');
        }

        $messageLines = [];
        $messageLines[] = 'Заявка с корзины (оформление заказа)';
        $messageLines[] = '';
        $messageLines[] = 'Состав заказа:';

        foreach ($lines as $line) {
            $p = $line['product'] ?? null;
            if (!$p) continue;

            $qty = (int)($line['qty'] ?? 0);
            $price = (int)($line['price'] ?? 0);
            $sum = (int)($line['sum'] ?? 0);

            $sku = $p->sku ? $p->sku : '—';
            $messageLines[] = "- {$p->title} (SKU: {$sku}) — {$qty} шт × {$price} ₽ = {$sum} ₽";
        }

        $total = (int)($cart['total'] ?? 0);
        $messageLines[] = '';
        $messageLines[] = 'Итого: ' . $total . ' ₽';

        if (!empty($data['comment'])) {
            $messageLines[] = '';
            $messageLines[] = 'Комментарий клиента:';
            $messageLines[] = trim($data['comment']);
        }

        Inquiry::create([
            'message' => implode("\n", $messageLines),
            'name' => $data['name'],
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'company' => null,
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        Cart::clear();

        return redirect('/cart')->with('ok', 'Заявка отправлена! Мы свяжемся с вами в ближайшее время.');
    }
}
