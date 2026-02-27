<?php

use App\Http\Controllers\Ajax\InquiryController;
use App\Http\Controllers\Ajax\PromoController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\ProductAdminController;

// Главная
Route::get('/', HomeController::class);

// Каталог + товары
Route::get('/pages/catalog.html', [CatalogController::class, 'index']);
Route::get('/catalog', [CatalogController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'show']);

// Старые страницы деталей -> редиректы
Route::redirect('/pages/detail/product.html', '/products/reduktor-mi-8', 301);
Route::redirect('/pages/detail/product2.html', '/products/lopast-mi-17', 301);
Route::redirect('/pages/detail/product3.html', '/products/nav-x4', 301);
Route::redirect('/pages/detail/product4.html', '/products/gidronasos-hp-240', 301);

// Корзина
Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart/add/{product}', [CartController::class, 'add']);
Route::post('/cart/update', [CartController::class, 'update']);
Route::post('/cart/remove/{product}', [CartController::class, 'remove']);
Route::post('/cart/clear', [CartController::class, 'clear']);
Route::post('/cart/checkout', [CheckoutController::class, 'store']);

// Админка товаров
Route::middleware(['auth', 'can:admin'])->prefix('admin')->group(function () {
    Route::resource('products', ProductAdminController::class)->except(['show']);
});

// Дашборд
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class);
});

// Новости
Route::get('/pages/news.html', [NewsController::class, 'index']);
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{slug}', [NewsController::class, 'show']);
Route::redirect('/pages/detail/news_detail.html', '/news/soglashenie-vsk-krdv-2025', 301);

// Auth
Route::get('/pages/login.html', [LoginController::class, 'show'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/pages/reg.html', [RegisterController::class, 'show']);
Route::post('/register', [RegisterController::class, 'store']);

// Статические .html страницы
Route::get('/pages/{page}.html', [PageController::class, 'show'])
    ->where('page', '[a-zA-Z0-9_\-]+');

// AJAX endpoints
Route::post('/ajax/message/send', [InquiryController::class, 'store']);
Route::post('/ajax/promo/send', [PromoController::class, 'store']);
