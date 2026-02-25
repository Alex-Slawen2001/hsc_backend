document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.carousel-slide');
    const prevBtn = document.querySelector('.carousel-prev');
    const nextBtn = document.querySelector('.carousel-next');
    let current = 0;
    const total = slides.length;

    function showSlide(index) {
        slides.forEach((slide, i) => {
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

    // Автопрокрутка каждые 5 секунд
    setInterval(nextSlide, 5000);

    showSlide(current);
});





document.addEventListener('DOMContentLoaded', () => {
    const slider = document.querySelector('.product-slider');
    const slides = document.querySelectorAll('.product-slide');
    const prevBtn = document.querySelector('.slider-prev');
    const nextBtn = document.querySelector('.slider-next');

    let index = 0;
    const slideWidth = slides[0].offsetWidth + 20; // ширина + gap

    function updateSlider() {
        slider.style.transform = `translateX(-${index * slideWidth}px)`;
    }

    nextBtn.addEventListener('click', () => {
        if(index < slides.length - 1) {
            index++;
        } else {
            index = 0;
        }
        updateSlider();
    });

    prevBtn.addEventListener('click', () => {
        if(index > 0) {
            index--;
        } else {
            index = slides.length - 1;
        }
        updateSlider();
    });
});


const burger = document.getElementById('burger');
const nav = document.getElementById('mobileNav');
const overlay = document.getElementById('navOverlay');
const navClose = document.getElementById('navClose');

function closeMenu() {
    nav.classList.remove('active');
    overlay.classList.remove('active');
}

burger.addEventListener('click', () => {
    nav.classList.toggle('active');
    overlay.classList.toggle('active');
});

overlay.addEventListener('click', closeMenu);
navClose.addEventListener('click', closeMenu);

nav.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', closeMenu);
});



but1 = document.getElementById('but_catalog1').addEventListener('click',function () {
    window.location.href = '/pages/catalog.html'
});
but2 = document.getElementById('but_catalog2').addEventListener('click',function (){
    window.location.href= "/pages/catalog.html"
});
but3 = document.getElementById('but_news1').addEventListener('click',function() {
    window.location.href = '/pages/detail/news_detail.html'
});
but4 = document.getElementById('but_news2').addEventListener('click',function() {
    window.location.href = '/pages/detail/news_detail.html'
});
but5 = document.getElementById('but_news3').addEventListener('click',function() {
    window.location.href = '/pages/detail/news_detail.html'
});

const buttons = document.querySelectorAll('[data-button="btn_product"]');

buttons.forEach(function(button, index) {
    button.addEventListener('click',function() {
        window.location.href = '/pages/modern.html'
    })
});

document.addEventListener('DOMContentLoaded', () => {
    const mq = window.matchMedia('(max-width: 768px)');

    function closeAllSubmenus(except = null) {
        document.querySelectorAll('.nav-item.has-submenu.is-open').forEach(item => {
            if (item !== except) item.classList.remove('is-open');
        });
    }

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


    document.addEventListener('click', (e) => {
        if (!mq.matches) return;
        if (e.target.closest('.nav-item.has-submenu')) return;
        closeAllSubmenus();
    });

    mq.addEventListener?.('change', () => closeAllSubmenus());
});


//     const burger = document.getElementById('burger');
//     const nav = document.querySelector('.header__nav');
//
//     if (burger && nav) {
//     burger.addEventListener('click', () => {
//         nav.classList.toggle('is-open');
//     });
// }

