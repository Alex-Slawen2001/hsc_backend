<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index', Cart::detailed());
    }

    public function add(Request $request, Product $product)
    {
        Cart::add($product, (int)$request->input('qty', 1));

        if ($request->ajax() || $request->wantsJson()) {
            $cart = Cart::detailed();
            return response()->json([
                'ok' => true,
                'message' => 'Товар добавлен в корзину',
                'cartCount' => (int)array_sum(Cart::items()),
                'total' => (int)($cart['total'] ?? 0),
            ]);
        }

        return redirect()->back()->with('ok', 'Товар добавлен в корзину');
    }

    public function update(Request $request)
    {
        foreach ((array)$request->input('items', []) as $productId => $qty) {
            Cart::setQty((int)$productId, (int)$qty);
        }

        if ($request->ajax() || $request->wantsJson()) {
            $cart = Cart::detailed();
            return response()->json([
                'ok' => true,
                'message' => 'Корзина обновлена',
                'cartCount' => (int)array_sum(Cart::items()),
                'total' => (int)($cart['total'] ?? 0),
            ]);
        }

        return redirect('/cart')->with('ok', 'Корзина обновлена');
    }

    public function remove(Request $request, Product $product)
    {
        Cart::remove($product->id);

        if ($request->ajax() || $request->wantsJson()) {
            $cart = Cart::detailed();
            return response()->json([
                'ok' => true,
                'message' => 'Товар удалён',
                'cartCount' => (int)array_sum(Cart::items()),
                'total' => (int)($cart['total'] ?? 0),
            ]);
        }

        return redirect('/cart')->with('ok', 'Товар удалён');
    }

    public function clear(Request $request)
    {
        Cart::clear();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'ok' => true,
                'message' => 'Корзина очищена',
                'cartCount' => 0,
                'total' => 0,
            ]);
        }

        return redirect('/cart')->with('ok', 'Корзина очищена');
    }
}
