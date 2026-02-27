<?php

namespace App\Http\Controllers;

use App\Models\Product;

class ProductController extends Controller
{
    public function show(string $slug)
    {
        $product = Product::query()->where('slug', $slug)->firstOrFail();

        $rawSpecs = $product->specs_json ?? [];
        $rawSpecs = is_array($rawSpecs) ? $rawSpecs : [];

        $specs = [];
        foreach ($rawSpecs as $row) {
            if (is_array($row) && count($row) === 2) {
                $specs[] = [$row[0], $row[1]];
            }
        }

        $compat = $product->compat_json ?? [];
        $compat = is_array($compat) ? $compat : [];

        $docs = $product->docs_json ?? [];
        $docs = is_array($docs) ? $docs : [];

        return view('catalog.show', [
            'product' => $product,
            'specs'   => $specs,
            'compat'  => $compat,
            'docs'    => $docs,
        ]);
    }
}
