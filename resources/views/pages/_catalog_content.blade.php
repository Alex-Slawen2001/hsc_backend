<div class="container">

    <div class="page-header">
        <div class="breadcrumbs">
            <a href="/">Главная</a><span class="crumb-sep">→</span>
            <a href="/pages/catalog.html">Каталог</a><span class="crumb-sep">→</span>
            <span>Запчасти</span>
        </div>
        <h1>Каталог запчастей для вертолётов</h1>
    </div>


    <div class="catalog-layout">


        <aside class="filters">

            <h3>Фильтры</h3>

            <div class="filter-group">
                <label>Модель вертолёта</label>
                <select>
                    <option>Все модели</option>
                    <option>Mi-8</option>
                    <option>Mi-17</option>
                    <option>Mi-26</option>
                    <option>Ka-32</option>
                    <option>Ansat</option>
                </select>
            </div>

            <div class="filter-group">
                <label>Номер детали (SKU)</label>
                <input type="text" placeholder="Введите артикул">
            </div>

            <div class="filter-group">
                <label>Цена до</label>
                <input type="text" placeholder="₽ ✎">
            </div>

        </aside>
        <section>
            <div class="catalog-toolbar">
                <div>Найдено: <strong>124</strong></div>
                <div class="sort">
                    <select>
                        <option>По умолчанию</option>
                        <option>Цена ↑</option>
                        <option>Цена ↓</option>
                        <option>По популярности</option>
                    </select>
                </div>
            </div>

            <div class="catalog-grid">

                <article class="product-card">
                    <div class="product-image"><img class="img_product" src="/styles/images/reductor.jpg"></div>
                    <div class="product-body">
                        <div class="product-title">Редуктор главной передачи</div>
                        <div class="product-sku">SKU: HSC-MI8-RGX01</div>
                        <div class="product-attrs">
                            Модель: Mi-8<br>
                            Категория: Трансмиссия<br>
                            Наличие: В наличии
                        </div>
                        <div class="product-price">₽ 1 450 000</div>
                        <a class="btn-primary" style="text-decoration: none;color: white;text-align: center" href="/pages/detail/product.html">Посмотреть</a>
                    </div>
                </article>

                <article class="product-card">
                    <div class="product-image"><img style="width: 70%;" class="img_product" src="/styles/images/lopast_vinta.png"></div>
                    <div class="product-body">
                        <div class="product-title">Лопасть несущего винта</div>
                        <div class="product-sku">SKU: HSC-MI17-BLD02</div>
                        <div class="product-attrs">
                            Модель: Mi-17<br>
                            Категория: Лопасти<br>
                            Наличие: Под заказ
                        </div>
                        <div class="product-price">₽ 980 000</div>
                        <a class="btn-primary" style="text-decoration: none;color: white;text-align: center" href="/pages/detail/product2.html">Посмотреть</a>
                    </div>
                </article>

                <article class="product-card">
                    <div class="product-image"><img class="img_product" src="/styles/images/block_avioniki.webp"></div>
                    <div class="product-body">
                        <div class="product-title">Блок авионики NAV-X4</div>
                        <div class="product-sku">SKU: HSC-NAV-X4</div>
                        <div class="product-attrs">
                            Универсальный<br>
                            Категория: Авионика<br>
                            Наличие: В наличии
                        </div>
                        <div class="product-price">₽ 320 000</div>
                        <a class="btn-primary" style="text-decoration: none;color: white;text-align: center" href="/pages/detail/product3.html">Посмотреть</a>
                    </div>
                </article>

                <article class="product-card">
                    <div class="product-image"><img style="height: 100%;" class="img_product" src="/styles/images/gidro.png"></div>
                    <div class="product-body">
                        <div class="product-title">Гидронасос HP-240</div>
                        <div class="product-sku">SKU: HSC-HYD-240</div>
                        <div class="product-attrs">
                            Категория: Гидравлика<br>
                            Наличие: В наличии
                        </div>
                        <div class="product-price">₽ 210 000</div>
                        <a class="btn-primary" style="text-decoration: none;color: white;text-align: center" href="/pages/detail/product4.html">Посмотреть</a>
                    </div>
                </article>

            </div>

            <div class="pagination">
                <a href="#">←</a>
                <a href="#" class="active">1</a>
                <a href="#">2</a>
                <a href="#">3</a>
                <a href="#">→</a>
            </div>

        </section>

    </div>
</div>

<style>
    /* Стили для полей фильтров (как на макете) */
    .filters select,
    .filters input[type="text"],
    .filters input[type="number"] {
        width: 100%;
        padding: 10px 12px;
        border: 2px solid #007bff; /* Яркая синяя обводка */
        border-radius: 8px;
        background-color: #f0f8ff; /* Светло-голубой фон (Aliceblue) */
        font-size: 15px;
        color: #003366;
        box-sizing: border-box;
        transition: 0.2s;
    }

    /* Для поля "Цена до" меняем тип на text, чтобы можно было добавить иконку в placeholder */
    .filters input[type="text"]::placeholder,
    .filters input[type="number"]::placeholder {
        color: #007bff;
        font-weight: 500;
        opacity: 0.8;
    }

    /* Убираем стрелки у number (для опрятного вида, если останется number) */
    .filters input[type="number"]::-webkit-outer-spin-button,
    .filters input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .filters input[type="number"] {
        -moz-appearance: textfield;
    }

    /* Дополнительно: сделаем метки жирными, как на макете */
    .filter-group label {
        font-weight: 600;
        margin-bottom: 6px;
        display: block;
        color: #222;
    }

    /* Небольшой отступ для групп */
    .filter-group {
        margin-bottom: 20px;
    }

    /* Общие стили для страницы (можно добавить, если их не было) */
    .catalog-layout {
        display: flex;
        gap: 30px;
        margin-top: 20px;
    }

    .filters {
        width: 260px;
        flex-shrink: 0;
    }

    section {
        flex: 1;
    }

    .catalog-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .catalog-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
        gap: 25px;
    }

    .product-card {
        border: 1px solid #eee;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        background: white;
    }

    .product-image {
        height: 160px;
        background: #f9f9f9;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .img_product {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .product-body {
        padding: 16px;
    }

    .btn-primary {
        display: block;
        background: #007bff;
        padding: 10px 0;
        border-radius: 6px;
        margin-top: 12px;
    }

    .pagination {
        margin-top: 35px;
        display: flex;
        gap: 8px;
    }

    .pagination a {
        padding: 8px 14px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        text-decoration: none;
        color: #007bff;
    }

    .pagination a.active {
        background: #007bff;
        color: white;
        border-color: #007bff;
    }
</style>
