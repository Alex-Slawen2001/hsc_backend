document.addEventListener('DOMContentLoaded', () => {
    // -------------------------
    // HERO carousel
    // -------------------------
    const heroSlides = document.querySelectorAll('.carousel-slide');
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');

    if (heroSlides.length && prevBtn && nextBtn) {
        let current = 0;
        const total = heroSlides.length;

        function showSlide(index) {
            heroSlides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
        }

        function nextSlide() {
            current = (current + 1) % total;
            showSlide(current);
        }

        function prevSlide() {
            current = (current - 1 + total) % total;
            showSlide(current);
        }

        nextBtn.addEventListener('click', nextSlide);
        prevBtn.addEventListener('click', prevSlide);

        setInterval(nextSlide, 5000);
        showSlide(current);
    }

    // -------------------------
    // Product slider (Модернизируем)
    // -------------------------
    const slider = document.querySelector('.product-slider');
    const slides = document.querySelectorAll('.product-slide');
    const sliderPrev = document.querySelector('.slider-prev');
    const sliderNext = document.querySelector('.slider-next');

    if (slider && slides.length && sliderPrev && sliderNext) {
        let index = 0;

        function getSlideWidth() {
            // ширина + gap
            const w = slides[0].offsetWidth || 0;
            return w ? (w + 20) : 0;
        }

        function updateSlider() {
            const slideWidth = getSlideWidth();
            if (!slideWidth) return;
            slider.style.transform = `translateX(-${index * slideWidth}px)`;
        }

        sliderNext.addEventListener('click', () => {
            index = (index < slides.length - 1) ? index + 1 : 0;
            updateSlider();
        });

        sliderPrev.addEventListener('click', () => {
            index = (index > 0) ? index - 1 : slides.length - 1;
            updateSlider();
        });

        window.addEventListener('resize', updateSlider);
        updateSlider();
    }

    // -------------------------
    // Кнопки на главной (без падений)
    // -------------------------
    const go = (id, url) => {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('click', () => window.location.href = url);
    };

    go('but_catalog1', '/pages/catalog.html');
    go('but_catalog2', '/pages/catalog.html');

    // Новости (у тебя сейчас редирект на старую деталь — оставляю как было)
    go('but_news1', '/pages/detail/news_detail.html');
    go('but_news2', '/pages/detail/news_detail.html');
    go('but_news3', '/pages/detail/news_detail.html');

    // -------------------------
    // Кнопки карточек "Мы модернизируем" -> вертолётная модернизация
    // -------------------------
    document.querySelectorAll('[data-button="btn_product"]').forEach(btn => {
        btn.addEventListener('click', () => {
            window.location.href = '/pages/modern.html';
        });
    });

    // -------------------------
    // Кнопки карточек "Каталог решений для дронов" -> модернизация дронов
    // -------------------------
    document.querySelectorAll('[data-button="dronCat"]').forEach(btn => {
        btn.addEventListener('click', () => {
            window.location.href = '/pages/modern_dron.html';
        });
    });

    // -------------------------
    // Мобильные подменю (оставляем твою логику, но безопасно)
    // -------------------------
    const mq = window.matchMedia('(max-width: 768px)');

    function closeAllSubmenus(except = null) {
        document.querySelectorAll('.nav-item.has-submenu.is-open').forEach(item => {
            if (item !== except) item.classList.remove('is-open');
        });
    }

    // перехват клика по "родителю"
    document.addEventListener('click', (e) => {
        if (!mq.matches) return;

        const parentLink = e.target.closest('.nav-item.has-submenu > a.nav-parent');
        if (!parentLink) return;

        e.preventDefault();
        e.stopPropagation();
        e.stopImmediatePropagation();

        const item = parentLink.closest('.nav-item.has-submenu');
        const willOpen = !item.classList.contains('is-open');

        closeAllSubmenus(item);
        item.classList.toggle('is-open', willOpen);
    }, true);

    // клик вне меню закрывает подменю
    document.addEventListener('click', (e) => {
        if (!mq.matches) return;
        if (e.target.closest('.nav-item.has-submenu')) return;
        closeAllSubmenus();
    });

    mq.addEventListener?.('change', () => closeAllSubmenus());
});
