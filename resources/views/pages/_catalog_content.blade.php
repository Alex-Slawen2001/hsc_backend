<div class="container">

    <div class="page-header">
        <div class="breadcrumbs">
            <a href="{{ url('/') }}">Главная</a><span class="crumb-sep">→</span>
            <a href="{{ url('/pages/catalog') }}">Каталог</a><span class="crumb-sep">→</span>
            <span>Запчасти</span>
        </div>
        <h1>Каталог запчастей для вертолётов</h1>
    </div>

    <div class="catalog-layout">

        <aside class="filters">
            <h3>Фильтры</h3>

            <div class="filter-group">
                <label for="helicopter-model">Модель вертолёта</label>
                <select name="helicopter_model" id="helicopter-model" class="filter-select">
                    <option value="">Все модели</option>
                    <option value="mi-8">Mi-8</option>
                    <option value="mi-17">Mi-17</option>
                    <option value="mi-26">Mi-26</option>
                    <option value="ka-32">Ka-32</option>
                    <option value="ansat">Ansat</option>
                </select>
            </div>

            <div class="filter-group">
                <label for="sku">Номер детали (SKU)</label>
                <input type="text" name="sku" id="sku" class="filter-input" placeholder="Введите артикул">
            </div>

            <div class="filter-group">
                <label for="price-to">Цена до</label>
                <input type="text"
                       name="price_to"
                       id="price-to"
                       class="filter-input"
                       placeholder="₽ ✎">
            </div>
        </aside>

        <section>
            <div class="catalog-toolbar">
                <div>Найдено: <strong>124</strong></div>
                <div class="sort">
                    <select name="sort" class="sort-select">
                        <option value="default">По умолчанию</option>
                        <option value="price_asc">Цена ↑</option>
                        <option value="price_desc">Цена ↓</option>
                        <option value="popular">По популярности</option>
                    </select>
                </div>
            </div>

            <div class="catalog-grid">
                <article class="product-card">
                    <div class="product-image">
                        <img class="img_product" src="{{ asset('styles/images/reductor.jpg') }}" alt="Редуктор главной передачи">
                    </div>
                    <div class="product-body">
                        <div class="product-title">Редуктор главной передачи</div>
                        <div class="product-sku">SKU: HSC-MI8-RGX01</div>
                        <div class="product-attrs">
                            Модель: Mi-8<br>
                            Категория: Трансмиссия<br>
                            Наличие: В наличии
                        </div>
                        <div class="product-price">₽ 1 450 000</div>
                        <a class="btn-primary" href="{{ url('/pages/detail/product') }}">Посмотреть</a>
                    </div>
                </article>

                <article class="product-card">
                    <div class="product-image">
                        <img style="width: 70%;" class="img_product" src="{{ asset('styles/images/lopast_vinta.png') }}" alt="Лопасть несущего винта">
                    </div>
                    <div class="product-body">
                        <div class="product-title">Лопасть несущего винта</div>
                        <div class="product-sku">SKU: HSC-MI17-BLD02</div>
                        <div class="product-attrs">
                            Модель: Mi-17<br>
                            Категория: Лопасти<br>
                            Наличие: Под заказ
                        </div>
                        <div class="product-price">₽ 980 000</div>
                        <a class="btn-primary" href="{{ url('/pages/detail/product2') }}">Посмотреть</a>
                    </div>
                </article>

                <article class="product-card">
                    <div class="product-image">
                        <img class="img_product" src="{{ asset('styles/images/block_avioniki.webp') }}" alt="Блок авионики">
                    </div>
                    <div class="product-body">
                        <div class="product-title">Блок авионики NAV-X4</div>
                        <div class="product-sku">SKU: HSC-NAV-X4</div>
                        <div class="product-attrs">
                            Универсальный<br>
                            Категория: Авионика<br>
                            Наличие: В наличии
                        </div>
                        <div class="product-price">₽ 320 000</div>
                        <a class="btn-primary" href="{{ url('/pages/detail/product3') }}">Посмотреть</a>
                    </div>
                </article>

                <article class="product-card">
                    <div class="product-image">
                        <img style="height: 100%;" class="img_product" src="{{ asset('styles/images/gidro.png') }}" alt="Гидронасос">
                    </div>
                    <div class="product-body">
                        <div class="product-title">Гидронасос HP-240</div>
                        <div class="product-sku">SKU: HSC-HYD-240</div>
                        <div class="product-attrs">
                            Категория: Гидравлика<br>
                            Наличие: В наличии
                        </div>
                        <div class="product-price">₽ 210 000</div>
                        <a class="btn-primary" href="{{ url('/pages/detail/product4') }}">Посмотреть</a>
                    </div>
                </article>
            </div>

            <div class="pagination">
                <a href="#" rel="prev">←</a>
                <a href="#" class="active" aria-current="page">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#" rel="next">→</a>
            </div>
        </section>
    </div>
</div>

<style>
    /* Стили для полей фильтров */
    .filter-select,
    .filter-input {
        width: 100%;
        padding: 10px 12px;
        border: 2px solid #007bff;
        border-radius: 8px;
        background-color: #f0f8ff;
        font-size: 15px;
        color: #003366;
        box-sizing: border-box;
        transition: all 0.2s ease;
    }

    .filter-input::placeholder {
        color: #007bff;
        font-weight: 500;
        opacity: 0.8;
    }

    .filter-select:hover,
    .filter-input:hover {
        border-color: #0056b3;
        background-color: #e6f2ff;
    }

    .filter-select:focus,
    .filter-input:focus {
        outline: none;
        border-color: #004999;
        background-color: #ffffff;
        box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.1);
    }

    .filter-group label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
        color: #333;
        font-size: 14px;
    }

    .filter-group {
        margin-bottom: 20px;
    }

    .filter-select {
        background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23007bff' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 16px;
        padding-right: 40px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    /* Основные стили каталога */
    .catalog-layout {
        display: flex;
        gap: 30px;
        margin-top: 20px;
    }

    .filters {
        width: 280px;
        flex-shrink: 0;
        background: #fff;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .filters h3 {
        margin-top: 0;
        margin-bottom: 20px;
        font-size: 18px;
        color: #222;
    }

    section {
        flex: 1;
    }

    .catalog-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        background: #fff;
        padding: 15px 20px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }

    .sort-select {
        padding: 8px 32px 8px 12px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        background-color: white;
        font-size: 14px;
        cursor: pointer;
        background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23333' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
        background-repeat: no-repeat;
        background-position: right 8px center;
        background-size: 14px;
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
    }

    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
        gap: 25px;
    }

    .product-card {
        border: 1px solid #eef2f6;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.03);
        background: white;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .product-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 24px rgba(0,123,255,0.12);
        border-color: #007bff;
    }

    .product-image {
        height: 180px;
        background: #f8faff;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
    }

    .img_product {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
        transition: transform 0.3s;
    }

    .product-card:hover .img_product {
        transform: scale(1.05);
    }

    .product-body {
        padding: 16px;
        border-top: 1px solid #eef2f6;
    }

    .product-title {
        font-weight: 600;
        font-size: 16px;
        margin-bottom: 6px;
        color: #222;
    }

    .product-sku {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 10px;
        padding-bottom: 10px;
        border-bottom: 1px dashed #eef2f6;
    }

    .product-attrs {
        font-size: 13px;
        color: #495057;
        line-height: 1.5;
        margin-bottom: 12px;
    }

    .product-price {
        font-size: 20px;
        font-weight: 700;
        color: #007bff;
        margin-bottom: 12px;
    }

    .btn-primary {
        display: block;
        background: #007bff;
        color: white;
        text-decoration: none;
        text-align: center;
        padding: 10px 0;
        border-radius: 6px;
        font-weight: 500;
        transition: background 0.2s;
    }

    .btn-primary:hover {
        background: #0056b3;
    }

    .pagination {
        margin-top: 35px;
        display: flex;
        gap: 8px;
        justify-content: center;
    }

    .pagination a {
        padding: 8px 14px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        text-decoration: none;
        color: #007bff;
        transition: all 0.2s;
        min-width: 40px;
        text-align: center;
    }

    .pagination a:hover {
        background: #e6f2ff;
        border-color: #007bff;
    }

    .pagination a.active {
        background: #007bff;
        color: white;
        border-color: #007bff;
        pointer-events: none;
    }

    @media (max-width: 768px) {
        .catalog-layout {
            flex-direction: column;
        }

        .filters {
            width: 100%;
        }

        .catalog-grid {
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        }
    }
</style>
