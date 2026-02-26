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
        return redirect('/cart')->with('ok', 'Товар добавлен в корзину');
    }

    public function update(Request $request)
    {
        foreach ((array)$request->input('items', []) as $productId => $qty) {
            Cart::setQty((int)$productId, (int)$qty);
        }
        return redirect('/cart')->with('ok', 'Корзина обновлена');
    }

    public function remove(Product $product)
    {
        Cart::remove($product->id);
        return redirect('/cart')->with('ok', 'Товар удалён');
    }

    public function clear()
    {
        Cart::clear();
        return redirect('/cart')->with('ok', 'Корзина очищена');
    }
}
