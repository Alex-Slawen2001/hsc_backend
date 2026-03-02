
    const burger = document.getElementById('burger');
    const nav = document.getElementById('mobileNav');
    const overlay = document.getElementById('navOverlay');
    const navClose = document.getElementById('navClose');

    function closeMenu() {
    nav.classList.remove('active');
    overlay.classList.remove('active');

    nav.querySelectorAll('.nav-item.has-submenu.is-open').forEach(item => item.classList.remove('is-open'));
}

    burger.addEventListener('click', () => {
    nav.classList.toggle('active');
    overlay.classList.toggle('active');
});

    overlay.addEventListener('click', closeMenu);
    navClose.addEventListener('click', closeMenu);

    nav.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', (e) => {
        if (link.classList.contains('nav-parent')) return;
        closeMenu();
    });
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




    document.addEventListener('DOMContentLoaded', () => {
    const filterButtons = Array.from(document.querySelectorAll('.system-filter__btn'));
    const searchInput = document.getElementById('systemSearch');
    const cards = Array.from(document.querySelectorAll('.system-card'));

    if (!filterButtons.length || !searchInput || !cards.length) return;

    let activeFilter = 'all';
    let query = '';

    function normalize(s) {
    return (s || '').toString().trim().toLowerCase();
}

    function applyFilters() {
    const q = normalize(query);

    cards.forEach(card => {
    const types = normalize(card.getAttribute('data-type'));
    const title = normalize(card.getAttribute('data-title'));
    const text = normalize(card.textContent);

    const matchFilter = activeFilter === 'all' || types.split(/\s+/).includes(activeFilter);
    const matchSearch = !q || title.includes(q) || text.includes(q);

    card.style.display = (matchFilter && matchSearch) ? '' : 'none';
});
}

    filterButtons.forEach(btn => {
    btn.addEventListener('click', () => {
    filterButtons.forEach(b => b.classList.remove('active'));
    btn.classList.add('active');
    activeFilter = btn.dataset.filter || 'all';
    applyFilters();
});
});

    searchInput.addEventListener('input', () => {
    query = searchInput.value;
    applyFilters();
});


    applyFilters();
});
