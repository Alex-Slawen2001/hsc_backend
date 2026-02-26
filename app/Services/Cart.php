<?php

namespace App\Services;

use App\Models\Product;

class Cart
{
    private const KEY = 'cart.items'; // [productId => qty]

    public static function items(): array
    {
        return session()->get(self::KEY, []);
    }

    public static function add(Product $product, int $qty = 1): void
    {
        $qty = max(1, $qty);
        $items = self::items();
        $items[$product->id] = ($items[$product->id] ?? 0) + $qty;
        session()->put(self::KEY, $items);
    }

    public static function setQty(int $productId, int $qty): void
    {
        $items = self::items();
        if ($qty <= 0) {
            unset($items[$productId]);
        } else {
            $items[$productId] = $qty;
        }
        session()->put(self::KEY, $items);
    }

    public static function remove(int $productId): void
    {
        $items = self::items();
        unset($items[$productId]);
        session()->put(self::KEY, $items);
    }

    public static function clear(): void
    {
        session()->forget(self::KEY);
    }

    public static function detailed(): array
    {
        $items = self::items();
        if (!$items) return ['lines' => [], 'total' => 0];

        $products = Product::query()
            ->whereIn('id', array_keys($items))
            ->get()
            ->keyBy('id');

        $lines = [];
        $total = 0;

        foreach ($items as $id => $qty) {
            $p = $products->get($id);
            if (!$p) continue;

            $price = (int)($p->price_rub ?? 0);
            $qty = (int)$qty;
            $sum = $price * $qty;

            $lines[] = compact('p','qty','price','sum');
            $total += $sum;
        }

        // нормализуем ключи для view
        $lines = array_map(fn($x) => [
            'product' => $x['p'],
            'qty' => $x['qty'],
            'price' => $x['price'],
            'sum' => $x['sum'],
        ], $lines);

        return ['lines' => $lines, 'total' => $total];
    }
}
