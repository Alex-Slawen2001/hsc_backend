<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductAdminController extends Controller
{
    public function index()
    {
        $products = Product::query()->orderByDesc('id')->paginate(20);
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']) ?: Str::random(8);

        // JSON поля из textarea
        $data['gallery_images'] = $this->jsonArray($request->input('gallery_images'));
        $data['specs_json']     = $this->jsonAssocOrPairs($request->input('specs_json'));
        $data['compat_json']    = $this->jsonArray($request->input('compat_json'));
        $data['docs_json']      = $this->jsonArray($request->input('docs_json'));

        Product::create($data);

        return redirect('/admin/products')->with('ok', 'Товар создан');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request, $product->id);

        $data['slug'] = $data['slug'] ?: Str::slug($data['title']) ?: Str::random(8);

        $data['gallery_images'] = $this->jsonArray($request->input('gallery_images'));
        $data['specs_json']     = $this->jsonAssocOrPairs($request->input('specs_json'));
        $data['compat_json']    = $this->jsonArray($request->input('compat_json'));
        $data['docs_json']      = $this->jsonArray($request->input('docs_json'));

        $product->update($data);

        return redirect('/admin/products')->with('ok', 'Товар обновлён');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect('/admin/products')->with('ok', 'Товар удалён');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title'        => ['required','string','max:255'],
            'slug'         => ['nullable','string','max:255','unique:products,slug' . ($ignoreId ? ',' . $ignoreId : '')],
            'sku'          => ['nullable','string','max:255'],
            'category'     => ['nullable','string','max:255'],
            'model'        => ['nullable','string','max:255'],
            'availability' => ['nullable','string','max:255'],
            'description'  => ['nullable','string'],
            'price_rub'    => ['nullable','integer','min:0'],
            'image_path'   => ['nullable','string','max:2048'],
        ]);
    }

    private function jsonArray(?string $raw): array
    {
        $raw = trim((string)$raw);
        if ($raw === '') return [];

        $decoded = json_decode($raw, true);
        if (is_array($decoded)) return array_values($decoded);

        $lines = preg_split("/\r\n|\n|\r/", $raw);
        return array_values(array_filter(array_map('trim', $lines), fn($v) => $v !== ''));
    }

    private function jsonAssocOrPairs(?string $raw): array
    {
        $raw = trim((string)$raw);
        if ($raw === '') return [];

        $decoded = json_decode($raw, true);
        if (is_array($decoded)) return $decoded;

        // fallback: строки "Ключ: Значение"
        $lines = preg_split("/\r\n|\n|\r/", $raw);
        $out = [];
        foreach ($lines as $line) {
            $line = trim($line);
            if ($line === '') continue;
            if (str_contains($line, ':')) {
                [$k, $v] = array_map('trim', explode(':', $line, 2));
                if ($k !== '') $out[$k] = $v;
            }
        }
        return $out;
    }
}
