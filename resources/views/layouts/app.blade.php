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

    <link rel="stylesheet" href="/styles/css/styles.css">
    @stack('styles')
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
                <a class="nav__link nav-parent" href="/pages/about.html">О нас</a>
                <div class="nav-submenu">
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
                <a href="/dashboard" class="nav__link">Кабинет</a>
                <form action="/logout" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="nav__link login_button" style="background:none;border:0;cursor:pointer">Выйти</button>
                </form>
            @else
                <a href="/pages/reg.html" class="nav__link reg_button">Регистрация</a>
                <a href="/pages/login.html" class="nav__link login_button">Войти</a>
            @endauth

        </nav>

        <div class="header__actions">
            @guest
                <a href="/pages/reg.html" class="btn-primary nav-cta">Регистрация</a>
            @endguest

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

{{-- Модалка консультации (как в исходнике) --}}
<div class="consult-modal" id="consultModal">
    <div class="consult-overlay js-close-consult"></div>

    <div class="consult-window">
        <button class="consult-close js-close-consult">✕</button>

        <h2 class="consult-title">Запросить консультацию</h2>
        <p class="consult-subtitle">Оставьте сообщение — мы свяжемся с вами в ближайшее время</p>

        <form action="/ajax/message/send" method="POST" id="consultForm">
            @csrf

            <div class="consult-grid">
                <div class="consult-field full">
                    <textarea name="Message" placeholder="Введите ваше сообщение*" required></textarea>
                    <div id="messageError"></div>
                </div>

                <div class="consult-field">
                    <input type="text" name="Name" placeholder="Ваше имя*" required>
                    <div id="nameError"></div>
                </div>

                <div class="consult-field">
                    <input type="email" name="Email" placeholder="Ваш e-mail">
                    <div id="emailError"></div>
                </div>

                <div class="consult-field">
                    <input type="tel" name="Phone" placeholder="Телефон">
                    <div id="phoneError"></div>
                </div>

                <div class="consult-field" style="display:none">
                    <input type="text" name="Company" placeholder="Компания">
                    <div id="companyError"></div>
                </div>
            </div>

            <button type="submit" class="consult-submit">Отправить запрос</button>
        </form>

    </div>
</div>

<script src="/styles/js/script.js"></script>
<script src="/styles/js/form.js"></script>
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
