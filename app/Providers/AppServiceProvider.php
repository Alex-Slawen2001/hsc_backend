<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::define('admin', fn ($user) => (bool)($user->is_admin ?? false));

        // Счётчик корзины считаем через composer (сессия уже поднята middleware).
        View::composer('*', function ($view) {
            $items = session()->get('cart.items', []);
            $count = 0;

            if (is_array($items)) {
                foreach ($items as $qty) {
                    $count += max(0, (int)$qty);
                }
            }

            $view->with('cartCount', $count);
        });
    }
}
