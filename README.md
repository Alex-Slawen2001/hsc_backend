# hscopter (Laravel)

Это перенос вашего статического проекта (HTML/CSS/JS) на Laravel с сохранением фронтенда и добавлением бэкенда:

- страницы как в исходнике (`/pages/*.html`)
- каталог и карточки товаров — из БД (seed)
- новости — из БД (seed)
- регистрация/вход — реальная авторизация Laravel
- формы «Консультация» и «Зафиксировать скидку» — реальные AJAX эндпоинты, данные сохраняются в БД
- старые URL детальных страниц (`/pages/detail/*.html`) настроены как 301 redirect на новые динамические страницы

## Требования

- PHP 8.2+
- Composer
- Любая БД (SQLite/MySQL/PostgreSQL)

## Быстрый старт (создание Laravel-проекта)

```bash
# 1) создаём чистый Laravel проект
composer create-project laravel/laravel hscopter
cd hscopter

# 2) копируем содержимое этой папки в корень проекта (с заменой файлов)
#    (app/, routes/, resources/, database/, public/styles, README)

# 3) настраиваем .env (БД)
cp .env.example .env
php artisan key:generate

# пример SQLite:
# touch database/database.sqlite
# в .env:
# DB_CONNECTION=sqlite
# DB_DATABASE=/absolute/path/to/database/database.sqlite

# 4) миграции + сиды
php artisan migrate --seed

# 5) запуск
php artisan serve
```

Откройте:

- `/` — главная
- `/pages/catalog.html` — каталог
- `/products/{slug}` — карточка товара
- `/pages/news.html` — новости
- `/news/{slug}` — детальная новость
- `/pages/login.html` и `/pages/reg.html` — вход и регистрация
- `/dashboard` — кабинет (после входа)

## Бэкенд эндпойнты

- `POST /ajax/message/send` — консультация (таблица `inquiries`)
- `POST /ajax/promo/send` — заявка на скидку (таблица `promo_leads`)

## Что лежит в БД после seed

- `products` — 4 товара из вашего каталога
- `news` — 4 новости (1 со «взятой» статьёй, остальные — заглушки)

## Примечания

- Пагинация Laravel выводится стандартным шаблоном (можно заменить на кастом под ваш дизайн).
- «Корзина»/оплата в исходнике не реализована — поэтому в карточке товара кнопка «В корзину» оставлена как демо.
