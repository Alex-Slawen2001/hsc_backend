@push('styles')
    <style>
        .adm-form{
            display:grid;
            gap:12px;
            max-width:900px;
        }

        .adm-grid-2{
            display:grid;
            grid-template-columns: 1fr 1fr;
            gap:12px;
        }

        .adm-grid-3{
            display:grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap:12px;
        }

        .adm-inp,
        .adm-ta{
            width:100%;
            padding:10px 12px;
            border-radius:12px;
            border:1px solid rgba(255,255,255,0.12);
            background: rgba(0,0,0,0.25);
            color:inherit;
            font-size:14px;
        }

        .adm-ta{
            resize: vertical;
            min-height: 120px;
        }

        .adm-label{
            font-size:13px;
            opacity:.7;
            margin-bottom:6px;
            display:block;
        }

        @media (max-width: 768px){
            .adm-grid-2,
            .adm-grid-3{
                grid-template-columns: 1fr;
            }

            .btn-primary,
            .btn-outline{
                width:100%;
            }
        }
    </style>
@endpush

@csrf

<div class="adm-form">

    <div>
        <label class="adm-label">Название *</label>
        <input name="title"
               class="adm-inp"
               required
               value="{{ old('title', $product->title ?? '') }}">
    </div>

    <div class="adm-grid-2">
        <div>
            <label class="adm-label">Slug (можно пусто)</label>
            <input name="slug"
                   class="adm-inp"
                   value="{{ old('slug', $product->slug ?? '') }}">
        </div>

        <div>
            <label class="adm-label">SKU</label>
            <input name="sku"
                   class="adm-inp"
                   value="{{ old('sku', $product->sku ?? '') }}">
        </div>
    </div>

    <div class="adm-grid-3">
        <div>
            <label class="adm-label">Категория</label>
            <input name="category"
                   class="adm-inp"
                   value="{{ old('category', $product->category ?? '') }}">
        </div>

        <div>
            <label class="adm-label">Модель</label>
            <input name="model"
                   class="adm-inp"
                   value="{{ old('model', $product->model ?? '') }}">
        </div>

        <div>
            <label class="adm-label">Цена (₽)</label>
            <input type="number"
                   min="0"
                   name="price_rub"
                   class="adm-inp"
                   value="{{ old('price_rub', $product->price_rub ?? 0) }}">
        </div>
    </div>

    <div>
        <label class="adm-label">Наличие</label>
        <input name="availability"
               class="adm-inp"
               value="{{ old('availability', $product->availability ?? '') }}">
    </div>

    <div>
        <label class="adm-label">Описание</label>
        <textarea name="description"
                  rows="6"
                  class="adm-ta">{{ old('description', $product->description ?? '') }}</textarea>
    </div>

    <div>
        <label class="adm-label">image_path (URL изображения)</label>
        <input name="image_path"
               class="adm-inp"
               value="{{ old('image_path', $product->image_path ?? '') }}">
    </div>

    <div>
        <label class="adm-label">gallery_images (JSON массив или по строкам)</label>
        <textarea name="gallery_images"
                  rows="4"
                  class="adm-ta">{{ old('gallery_images', isset($product) ? json_encode($product->gallery_images ?? [], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '') }}</textarea>
    </div>

    <div>
        <label class="adm-label">specs_json (JSON объект или строки "Ключ: Знач")</label>
        <textarea name="specs_json"
                  rows="6"
                  class="adm-ta">{{ old('specs_json', isset($product) ? json_encode($product->specs_json ?? [], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '') }}</textarea>
    </div>

    <div>
        <label class="adm-label">compat_json (JSON массив или по строкам)</label>
        <textarea name="compat_json"
                  rows="4"
                  class="adm-ta">{{ old('compat_json', isset($product) ? json_encode($product->compat_json ?? [], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '') }}</textarea>
    </div>

    <div>
        <label class="adm-label">docs_json (JSON массив или по строкам)</label>
        <textarea name="docs_json"
                  rows="4"
                  class="adm-ta">{{ old('docs_json', isset($product) ? json_encode($product->docs_json ?? [], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '') }}</textarea>
    </div>

    @if($errors->any())
        <div style="padding:12px;border-radius:12px;border:1px solid #e74c3c;background:rgba(231,76,60,.08);">
            <b>Ошибки:</b>
            <ul style="margin:8px 0 0;padding-left:18px;">
                @foreach($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <button class="btn-primary" type="submit">Сохранить</button>
        <a class="btn-outline" href="/admin/products">Назад</a>
    </div>

</div>
