
    document.addEventListener('DOMContentLoaded', () => {

    const yearLinks = Array.from(document.querySelectorAll('.year-filter a'));
    const newsCards = Array.from(document.querySelectorAll('.news-card'));
    const pagination = document.querySelector('.pagination');

    if (!yearLinks.length || !newsCards.length) return;

    function getYear(card) {
    const dateEl = card.querySelector('.news-date');
    if (!dateEl) return '';
    const match = dateEl.textContent.trim().match(/^(\d{4})/);
    return match ? match[1] : '';
}

    function setActive(activeLink) {
    yearLinks.forEach(link =>
    link.classList.toggle('active', link === activeLink)
    );
}

    function applyFilter(year) {
    let visibleCount = 0;

    newsCards.forEach(card => {
    const cardYear = getYear(card);
    const show = year === 'Все новости' || cardYear === year;
    card.style.display = show ? '' : 'none';
    if (show) visibleCount++;
});

    if (pagination) {
    pagination.style.display = visibleCount ? '' : 'none';
}
}

    const defaultLink = yearLinks.find(a => a.textContent.trim() === 'Все новости') || yearLinks[0];
    setActive(defaultLink);
    applyFilter(defaultLink.textContent.trim());

    yearLinks.forEach(link => {
    link.addEventListener('click', e => {
    e.preventDefault();
    const year = link.textContent.trim();
    setActive(link);
    applyFilter(year);
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
});
});

