document.addEventListener('DOMContentLoaded', () => {
    setTimeout(initializeCatalogFilter, 0);
});

function initializeCatalogFilter() {
    const cards = Array.from(document.querySelectorAll('.product-card'));
    if (!cards.length) return;

    const filterModel = document.querySelector('.filters select:nth-of-type(1)');
    const filterCategory = document.querySelector('.filters select:nth-of-type(2)');
    const filterSku = document.querySelector('.filters input[type="text"]');
    const filterPrice = document.querySelector('.filters input[type="number"]');
    const sortSelect = document.querySelector('.sort select');
    const foundCount = document.querySelector('.catalog-toolbar strong');
    const grid = document.querySelector('.catalog-grid');

    const norm = (s) =>
        (s || '')
            .toString()
            .replace(/\u00A0/g, ' ')
            .toLowerCase()
            .trim()
            .replace(/\s+/g, ' ');

    const normCategory = (s) => {
        const t = norm(s);
        if (t === 'авионика' || t === 'авиаоника') return 'авиаоника';
        return t;
    };

    const parsePrice = (el) => {
        const txt = el ? el.textContent : '';
        const digits = (txt || '').replace(/[^\d]/g, '');
        return parseInt(digits, 10) || 0;
    };

    const products = cards.map((card, index) => {
        const titleEl = card.querySelector('.product-title');
        const skuEl = card.querySelector('.product-sku');
        const priceEl = card.querySelector('.product-price');

        const title = titleEl ? titleEl.textContent.trim() : `Товар ${index + 1}`;
        const sku = skuEl ? skuEl.textContent.replace('SKU:', '').trim() : '';
        const price = parsePrice(priceEl);

        const text = norm(card.innerText || card.textContent || '');

        return { element: card, title, sku, price, text, originalIndex: index };
    });

    const showCard = (el) => {
        el.style.display = '';
        el.removeAttribute('hidden');
    };

    const hideCard = (el) => {
        el.style.display = 'none';
        el.setAttribute('hidden', 'hidden');
    };

    function updateCatalog() {
        const selectedModel = norm(filterModel ? filterModel.value : '');
        const selectedCategory = normCategory(filterCategory ? filterCategory.value : '');
        const skuSearch = norm(filterSku ? filterSku.value : '');
        const maxPrice = filterPrice && filterPrice.value ? parseInt(filterPrice.value, 10) : 0;
        const sortBy = sortSelect ? sortSelect.value : 'По умолчанию';

        const allModels = norm('Все модели');
        const allCats = normCategory('Все категории');

        const visible = [];

        for (const p of products) {
            let ok = true;

            if (selectedModel && selectedModel !== allModels) {
                if (!p.text.includes(norm('модель:') + ' ' + selectedModel) && !p.text.includes(selectedModel)) ok = false;
            }

            if (ok && selectedCategory && selectedCategory !== allCats) {
                const hasCat =
                    p.text.includes(norm('категория:') + ' ' + selectedCategory) ||
                    p.text.includes(selectedCategory) ||
                    (selectedCategory === 'авиаоника' && (p.text.includes('авионика') || p.text.includes('авиаоника')));
                if (!hasCat) ok = false;
            }

            if (ok && skuSearch) {
                if (!norm(p.sku).includes(skuSearch)) ok = false;
            }

            if (ok && maxPrice > 0) {
                if (p.price > maxPrice) ok = false;
            }

            if (ok) {
                showCard(p.element);
                visible.push(p);
            } else {
                hideCard(p.element);
            }
        }

        if (sortBy === 'Цена ↑') visible.sort((a, b) => a.price - b.price);
        else if (sortBy === 'Цена ↓') visible.sort((a, b) => b.price - a.price);
        else if (sortBy === 'По популярности') visible.sort((a, b) => a.title.localeCompare(b.title, 'ru'));
        else visible.sort((a, b) => a.originalIndex - b.originalIndex);

        if (grid) {
            for (const p of visible) grid.appendChild(p.element);
            for (const p of products) if (!visible.includes(p)) grid.appendChild(p.element);
        }

        if (foundCount) foundCount.textContent = visible.length;
    }

    const debounce = (fn, ms) => {
        let t;
        return function () {
            clearTimeout(t);
            t = setTimeout(fn, ms);
        };
    };

    if (filterModel) filterModel.addEventListener('change', updateCatalog);
    if (filterCategory) filterCategory.addEventListener('change', updateCatalog);
    if (sortSelect) sortSelect.addEventListener('change', updateCatalog);

    if (filterSku) filterSku.addEventListener('input', debounce(updateCatalog, 200));
    if (filterPrice) filterPrice.addEventListener('input', debounce(updateCatalog, 200));

    if (foundCount) foundCount.textContent = products.length;
    updateCatalog();
}
