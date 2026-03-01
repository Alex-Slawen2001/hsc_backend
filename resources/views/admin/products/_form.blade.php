@push('styles')
    <style>
        .adm-form-wrap{ padding:24px 0; }
        @media (max-width: 768px){
            .adm-form-wrap.container{
                padding-left:16px !important;
                padding-right:16px !important;
            }
        }

        .adm-form{
            display:grid;
            gap:14px;
            max-width: 980px;
            margin: 0 auto;
        }

        .adm-head{
            display:flex;
            align-items:flex-end;
            justify-content:space-between;
            gap:12px;
            flex-wrap:wrap;
            margin-bottom: 6px;
        }

        .adm-head h1{ margin:0; font-size:26px; letter-spacing:-.2px; }
        .adm-subtitle{ opacity:.72; font-size:13px; margin-top:6px; }

        .adm-card{
            border:1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.03);
            border-radius:18px;
            padding:14px;
        }

        .adm-card-title{
            margin:0 0 12px;
            font-size:15px;
            font-weight:800;
            letter-spacing:-.1px;
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

        .adm-field{ min-width:0; }
        .adm-label{
            font-size:13px;
            opacity:.75;
            margin-bottom:6px;
            display:flex;
            gap:8px;
            align-items:center;
        }
        .adm-hint{
            font-size:12px;
            opacity:.55;
            margin-top:6px;
            line-height:1.35;
        }

        .adm-inp,
        .adm-ta{
            width:100%;
            padding:11px 12px;
            border-radius:14px;
            border:1px solid rgba(255,255,255,0.12);
            background: rgba(0,0,0,0.25);
            color:inherit;
            font-size:14px;
            outline:none;
            box-sizing:border-box;
        }

        .adm-inp:focus,
        .adm-ta:focus{
            border-color: rgba(78,127,255,.55);
            box-shadow: 0 0 0 3px rgba(78,127,255,.14);
        }

        .adm-ta{
            resize: vertical;
            min-height: 120px;
        }

        .adm-error-block{
            padding:12px;
            border-radius:14px;
            border:1px solid rgba(231,76,60,.8);
            background: rgba(231,76,60,.08);
        }
        .adm-error-field{
            border-color: rgba(231,76,60,.9) !important;
            box-shadow: 0 0 0 3px rgba(231,76,60,.12) !important;
        }
        .adm-error-text{
            margin-top:6px;
            font-size:12px;
            color:#ffb3b3;
        }

        .adm-media{
            display:grid;
            grid-template-columns: 1fr 320px;
            gap:12px;
            align-items:start;
        }
        .adm-preview{
            border:1px solid rgba(255,255,255,.12);
            border-radius:16px;
            overflow:hidden;
            background: rgba(0,0,0,.20);
        }
        .adm-preview img{
            width:100%;
            aspect-ratio: 16/10;
            object-fit:cover;
            display:block;
            background: rgba(255,255,255,.06);
        }
        .adm-preview .adm-preview-empty{
            padding:14px;
            font-size:13px;
            opacity:.65;
        }

        .adm-actions{
            display:flex;
            gap:10px;
            flex-wrap:wrap;
            justify-content:flex-end;
        }
        .adm-actions .btn-primary,
        .adm-actions .btn-outline{
            padding: 10px 14px;
            border-radius: 14px;
            line-height:1.1;
        }

        @media (max-width: 980px){
            .adm-media{ grid-template-columns: 1fr; }
        }
        @media (max-width: 768px){
            .adm-grid-2,
            .adm-grid-3{
                grid-template-columns: 1fr;
            }
            .adm-actions{
                justify-content:stretch;
            }
            .adm-actions .btn-primary,
            .adm-actions .btn-outline{
                width:100%;
            }
        }
    </style>
@endpush

@csrf

<div class="adm-form-wrap container">
    <div class="adm-form">

        {{-- Заголовок --}}
        <div class="adm-head">
            <div>
                <h1>{{ isset($product) ? 'Редактирование товара' : 'Добавление товара' }}</h1>
                <div class="adm-subtitle">Заполняйте поля аккуратно — данные используются в карточке, детальной странице и табах.</div>
            </div>

            <div class="adm-actions">
                <a class="btn-outline" href="/admin/products">← Назад</a>
                <button class="btn-primary" type="submit">Сохранить</button>
            </div>
        </div>

        {{-- Общие ошибки --}}
        @if($errors->any())
            <div class="adm-error-block">
                <b>Ошибки:</b>
                <ul style="margin:8px 0 0;padding-left:18px;">
                    @foreach($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Основное --}}
        <div class="adm-card">
            <div class="adm-card-title">Основное</div>

            <div class="adm-field">
                <label class="adm-label">Название *</label>
                <input
                    name="title"
                    class="adm-inp @error('title') adm-error-field @enderror"
                    required
                    value="{{ old('title', $product->title ?? '') }}"
                >
                @error('title')<div class="adm-error-text">{{ $message }}</div>@enderror
            </div>

            <div class="adm-grid-2" style="margin-top:12px;">
                <div class="adm-field">
                    <label class="adm-label">Slug <span class="adm-hint" style="margin:0;">(можно пусто)</span></label>
                    <input
                        name="slug"
                        class="adm-inp @error('slug') adm-error-field @enderror"
                        value="{{ old('slug', $product->slug ?? '') }}"
                    >
                    @error('slug')<div class="adm-error-text">{{ $message }}</div>@enderror
                </div>

                <div class="adm-field">
                    <label class="adm-label">SKU</label>
                    <input
                        name="sku"
                        class="adm-inp @error('sku') adm-error-field @enderror"
                        value="{{ old('sku', $product->sku ?? '') }}"
                    >
                    @error('sku')<div class="adm-error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="adm-grid-3" style="margin-top:12px;">
                <div class="adm-field">
                    <label class="adm-label">Категория</label>
                    <input
                        name="category"
                        class="adm-inp @error('category') adm-error-field @enderror"
                        value="{{ old('category', $product->category ?? '') }}"
                    >
                    @error('category')<div class="adm-error-text">{{ $message }}</div>@enderror
                </div>

                <div class="adm-field">
                    <label class="adm-label">Модель</label>
                    <input
                        name="model"
                        class="adm-inp @error('model') adm-error-field @enderror"
                        value="{{ old('model', $product->model ?? '') }}"
                    >
                    @error('model')<div class="adm-error-text">{{ $message }}</div>@enderror
                </div>

                <div class="adm-field">
                    <label class="adm-label">Цена (₽)</label>
                    <input
                        type="number"
                        min="0"
                        name="price_rub"
                        class="adm-inp @error('price_rub') adm-error-field @enderror"
                        value="{{ old('price_rub', $product->price_rub ?? 0) }}"
                    >
                    @error('price_rub')<div class="adm-error-text">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="adm-field" style="margin-top:12px;">
                <label class="adm-label">Наличие</label>
                <input
                    name="availability"
                    class="adm-inp @error('availability') adm-error-field @enderror"
                    value="{{ old('availability', $product->availability ?? '') }}"
                >
                @error('availability')<div class="adm-error-text">{{ $message }}</div>@enderror
                <div class="adm-hint">Пример: “В наличии”, “Под заказ 7–10 дней”, “Нет в наличии”.</div>
            </div>
        </div>

        {{-- Описание --}}
        <div class="adm-card">
            <div class="adm-card-title">Описание</div>

            <div class="adm-field">
                <label class="adm-label">Описание</label>
                <textarea
                    name="description"
                    rows="6"
                    class="adm-ta @error('description') adm-error-field @enderror"
                >{{ old('description', $product->description ?? '') }}</textarea>
                @error('description')<div class="adm-error-text">{{ $message }}</div>@enderror
                <div class="adm-hint">Поддерживается обычный текст. HTML лучше хранить отдельно, если нужно.</div>
            </div>
        </div>

        {{-- Медиа --}}
        <div class="adm-card">
            <div class="adm-card-title">Медиа</div>

            <div class="adm-media">
                <div>
                    <div class="adm-field">
                        <label class="adm-label">image_path (URL изображения)</label>
                        <input
                            id="imagePathInput"
                            name="image_path"
                            class="adm-inp @error('image_path') adm-error-field @enderror"
                            value="{{ old('image_path', $product->image_path ?? '') }}"
                        >
                        @error('image_path')<div class="adm-error-text">{{ $message }}</div>@enderror
                        <div class="adm-hint">Вставь полный URL или путь к файлу. Пример: /storage/products/1.jpg</div>
                    </div>

                    <div class="adm-field" style="margin-top:12px;">
                        <label class="adm-label">gallery_images (JSON массив или по строкам)</label>
                        <textarea
                            name="gallery_images"
                            rows="4"
                            class="adm-ta @error('gallery_images') adm-error-field @enderror"
                        >{{ old('gallery_images', isset($product) ? json_encode($product->gallery_images ?? [], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '') }}</textarea>
                        @error('gallery_images')<div class="adm-error-text">{{ $message }}</div>@enderror
                        <div class="adm-hint">Можно JSON-массив: ["url1","url2"] или просто по одному URL на строку.</div>
                    </div>
                </div>

                <div class="adm-preview" id="imagePreviewBox">
                    @php($preview = old('image_path', $product->image_path ?? ''))
                    @if($preview)
                        <img id="imagePreview" src="{{ $preview }}" alt="preview">
                    @else
                        <div class="adm-preview-empty">Превью появится, когда заполните <b>image_path</b>.</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- JSON поля для табов --}}
        <div class="adm-card">
            <div class="adm-card-title">Данные для табов (JSON)</div>

            <div class="adm-field">
                <label class="adm-label">specs_json (JSON объект или строки "Ключ: Знач")</label>
                <textarea
                    name="specs_json"
                    rows="6"
                    class="adm-ta @error('specs_json') adm-error-field @enderror"
                >{{ old('specs_json', isset($product) ? json_encode($product->specs_json ?? [], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '') }}</textarea>
                @error('specs_json')<div class="adm-error-text">{{ $message }}</div>@enderror
                <div class="adm-hint">Пример JSON: {"Материал":"Алюминий","Момент":"4500 Нм"}</div>
            </div>

            <div class="adm-grid-2" style="margin-top:12px;">
                <div class="adm-field">
                    <label class="adm-label">compat_json (JSON массив или по строкам)</label>
                    <textarea
                        name="compat_json"
                        rows="4"
                        class="adm-ta @error('compat_json') adm-error-field @enderror"
                    >{{ old('compat_json', isset($product) ? json_encode($product->compat_json ?? [], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '') }}</textarea>
                    @error('compat_json')<div class="adm-error-text">{{ $message }}</div>@enderror
                    <div class="adm-hint">Пример: ["Mi-8T","Mi-17","Mi-171"]</div>
                </div>

                <div class="adm-field">
                    <label class="adm-label">docs_json (JSON массив или по строкам)</label>
                    <textarea
                        name="docs_json"
                        rows="4"
                        class="adm-ta @error('docs_json') adm-error-field @enderror"
                    >{{ old('docs_json', isset($product) ? json_encode($product->docs_json ?? [], JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT) : '') }}</textarea>
                    @error('docs_json')<div class="adm-error-text">{{ $message }}</div>@enderror
                    <div class="adm-hint">Пример: [{"title":"Паспорт изделия","url":"..."}]</div>
                </div>
            </div>
        </div>

        {{-- Нижние кнопки --}}
        <div class="adm-actions" style="justify-content:space-between;">
            <a class="btn-outline" href="/admin/products">← Назад</a>
            <button class="btn-primary" type="submit">Сохранить</button>
        </div>

    </div>
</div>

@push('scripts')
    <script>
        // Превью image_path
        (function(){
            const inp = document.getElementById('imagePathInput');
            const box = document.getElementById('imagePreviewBox');
            if(!inp || !box) return;

            let img = box.querySelector('#imagePreview');

            function setPreview(url){
                const v = (url || '').trim();
                if(!v){
                    box.innerHTML = '<div class="adm-preview-empty">Превью появится, когда заполните <b>image_path</b>.</div>';
                    img = null;
                    return;
                }

                if(!img){
                    box.innerHTML = '<img id="imagePreview" src="" alt="preview">';
                    img = box.querySelector('#imagePreview');
                }
                img.src = v;
            }

            inp.addEventListener('input', () => setPreview(inp.value));
        })();
    </script>
@endpush
