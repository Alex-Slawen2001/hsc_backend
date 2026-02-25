<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::query()->where('slug', $slug)->firstOrFail();


        $rawSpecs = $product->specs_json ?? $product->specs ?? [];
        $rawSpecs = is_array($rawSpecs) ? $rawSpecs : [];

        $specs = [];
        foreach ($rawSpecs as $k => $v) {
            if (is_int($k) && is_array($v) && count($v) === 2) {
                $specs[] = [$v[0], $v[1]];
                continue;
            }
            $specs[] = [$k, $v];
        }

        $compat = $product->compat_json ?? $product->compatibility ?? [];
        $compat = is_array($compat) ? $compat : [];

        $docs = $product->docs_json ?? $product->docs ?? $product->documents ?? [];
        $docs = is_array($docs) ? $docs : [];

        return view('catalog.show', [
            'product' => $product,
            'specs'   => $specs,
            'compat'  => $compat,
            'docs'    => $docs,
        ]);
    }
}
