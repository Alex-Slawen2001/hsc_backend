<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'HSC Copter')</title>
    <meta name="description" content="HSC Copter — профессиональные беспилотные решения и дроны">

    <link rel="shortcut icon" href="/styles/images/hsc-favicon_all.ico" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.__CSRF_TOKEN__ = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>

    <link rel="stylesheet" href="{{ asset('styles/css/main.css') }}">
    @stack('styles')

    <style>
        /* BURGER */
        .burger {
            display: none;
            flex-direction: column;
            justify-content: space-between;
            width: 30px;
            height: 20px;
            background: transparent;
            border: none;
            cursor: pointer;
            padding: 0;
            z-index: 100;
        }

        .burger span {
            width: 100%;
            height: 3px;
            background: #ffffff;
            transition: all 0.3s;
            border-radius: 2px;
        }

        @media (max-width: 992px) {
            .burger {
                display: flex !important;
            }
        }

        /* DESKTOP */
        @media (min-width: 993px) {

            .nav .reg_button,
            .nav .login_button,
            .nav form button.nav__link {
                display: none;
            }

            .header__actions .btn-primary,
            .header__actions .btn-outline {
                display: inline-block;
            }

            .header-inner {
                display: flex;
                align-items: center;
                justify-content: space-between;
            }

            .nav {
                display: flex !important;
                align-items: center;
                justify-content: center;
                gap: 25px;
                flex: 1;
                margin: 0 20px;
            }

            .burger {
                display: none !important;
            }
        }

        /* MOBILE */
        @media (max-width: 992px) {

            /* скрываем кнопки справа */
            .header__actions .btn-primary,
            .header__actions .btn-outline,
            .header__actions form {
                display: none !important;
            }

            /* ✅ Регистрация / Войти как обычные пункты меню */
            .nav .reg_button,
            .nav .login_button {
                display: block;
                width: auto;
                text-align: left;
                margin: 0;
            }

            /* ❗ ВЫЙТИ НЕ ТРОГАЕМ */
            .nav form button.nav__link {
                display: block;
                width: 100%;
                text-align: center;
                margin: 5px 0;
            }

            /* убираем кабинет из моб меню */
            .nav a[href="/dashboard"] {
                display: none;
            }

            /* красная кнопка выйти */
            .nav form button.nav__link {
                border: 2px solid #ff0000 !important;
                color: #ff0000 !important;
                background: transparent !important;
                border-radius: 5px !important;
                padding: 10px !important;
                font-weight: bold !important;
            }
        }

        /* убираем лишние */
        .header .nav .btn-primary,
        .header .nav .btn-outline {
            display: none;
        }

        .header .header__actions .reg_button,
        .header .header__actions .login_button {
            display: none;
        }

        .header__actions .btn-primary,
        .header__actions .btn-outline,
        .header__actions form button {
            min-width: 100px;
            text-align: center;
            padding: 8px 16px;
            box-sizing: border-box;
            display: inline-block;
        }

        .header__actions form {
            display: inline-block;
            margin: 0;
        }
    </style>
</head>
<body>

<header class="header">
    <div class="container header-inner">

        <div class="logo">
            <a href="/">
                <img style="width: 50%;" src="/styles/images/logo.png" alt="HSC Copter">
            </a>
        </div>

        <nav class="nav" id="mobileNav">

            <button class="nav-close" id="navClose" aria-label="Закрыть меню">
                <span></span><span></span>
            </button>

            <a href="/" class="nav__link">Главная</a>

            <div class="nav-item has-submenu">
                <a class="nav__link nav-parent" href="#">Инфо</a>
                <div class="nav-submenu">
                    <a class="nav-submenu__link" href="/pages/about.html">О нас</a>
                    <a class="nav-submenu__link" href="/pages/obuchenie.html">Обучение</a>
                    <a class="nav-submenu__link" href="/pages/document.html">Документация</a>
                </div>
            </div>

            <a href="/pages/catalog.html" class="nav__link">Каталог</a>
            <a href="/pages/news.html" class="nav__link">Новости</a>

            <div class="nav-item has-submenu">
                <a class="nav__link nav-parent" href="/pages/modern.html">Модернизация</a>
                <div class="nav-submenu">
                    <a class="nav-submenu__link" href="/pages/modern.html">Вертолёты</a>
                    <a class="nav-submenu__link" href="/pages/modern_dron.html">Дроны</a>
                </div>
            </div>

            <a href="/pages/contacts.html" class="nav__link">Контакты</a>

            @auth
                <form action="/logout" method="POST" style="display:inline; width:100%;">
                    @csrf
                    <button type="submit" class="nav__link login_button" style="background:none; cursor:pointer; width:100%;">
                        Выйти
                    </button>
                </form>
            @else
                <a href="/pages/reg.html" class="nav__link reg_button">Регистрация</a>
                <a href="/pages/login.html" class="nav__link login_button">Войти</a>
            @endauth

        </nav>

        <div class="header__actions">
            @auth
                <a href="/dashboard" class="btn-primary nav-cta" style="text-decoration:none;">Кабинет</a>
                <form action="/logout" method="POST" style="display:inline; margin:0;">
                    @csrf
                    <button type="submit" class="btn-outline nav-cta" style="cursor:pointer;">
                        Выйти
                    </button>
                </form>
            @else
                <a href="/pages/reg.html" class="btn-primary nav-cta">Регистрация</a>
                <a href="/pages/login.html" class="btn-outline nav-cta">Войти</a>
            @endauth

            <button class="burger" id="burger" aria-label="Открыть меню">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>

    <div class="nav-overlay" id="navOverlay"></div>
</header>

@yield('content')

<footer class="footer">
    <div class="container footer-grid">
        <div class="footer-brand">
            <strong class="footer-logo">HSC Copter</strong>
            <p class="footer-desc">
                Профессиональные беспилотные технологии и решения для промышленности
            </p>
        </div>

        <div class="footer-nav">
            <h4>Навигация</h4>
            <a href="/">Главная</a>
            <a href="/pages/catalog.html">Каталог</a>
            <a href="/pages/news.html">Новости</a>
            <a href="/pages/about.html">О нас</a>
            <a href="/pages/document.html">Документация</a>
            <a href="/pages/obuchenie.html">Обучение</a>
        </div>

        <div class="footer-contacts">
            <h4>Контакты</h4>
            <a href="mailto:info@hsc-copter.com">info@hsc-copter.com</a>
            <a href="tel:+70000000000">+7 (000) 000-00-00</a>
            <span class="footer-note">Пн–Пт, 9:00–18:00</span>
        </div>
    </div>

    <div class="footer-bottom">
        © 2026 HSC Copter. Все права защищены
    </div>
</footer>

<script src="{{ asset('styles/js/script.js') }}"></script>
<script src="{{ asset('styles/js/form.js') }}"></script>
@stack('scripts')

<script>
    const burger = document.getElementById('burger');
    const nav = document.getElementById('mobileNav');
    const overlay = document.getElementById('navOverlay');
    const navClose = document.getElementById('navClose');

    function closeMenu() {
        nav.classList.remove('active');
        overlay.classList.remove('active');
    }

    if (burger) burger.addEventListener('click', () => {
        nav.classList.toggle('active');
        overlay.classList.toggle('active');
    });

    if (overlay) overlay.addEventListener('click', closeMenu);
    if (navClose) navClose.addEventListener('click', closeMenu);

    if (nav) nav.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', closeMenu);
    });
</script>

</body>
</html>
