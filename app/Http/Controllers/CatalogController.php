<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        // Основная выдача — с пагинацией.
        // Фильтры на фронте (как в исходнике) оставляем, но поддержим и серверные параметры (на будущее).
        $q = Product::query();

        if ($request->filled('model')) {
            $q->where('model', $request->string('model'));
        }
        if ($request->filled('category')) {
            $q->where('category', $request->string('category'));
        }
        if ($request->filled('sku')) {
            $q->where('sku', 'like', '%' . $request->string('sku') . '%');
        }
        if ($request->filled('price_to')) {
            $q->where('price_rub', '<=', (int)$request->input('price_to'));
        }

        $products = $q->orderBy('id')->paginate(12)->withQueryString();

        return view('catalog.index', compact('products'));
    }
}
