document.addEventListener("DOMContentLoaded", function () {

    const burger = document.getElementById("burger");
    const nav = document.getElementById("mobileNav");
    const overlay = document.getElementById("navOverlay");
    const navClose = document.getElementById("navClose");

    function closeMenu() {
        if (!nav || !overlay) return;

        nav.classList.remove("active");
        overlay.classList.remove("active");

        nav.querySelectorAll(".nav-item.has-submenu.is-open").forEach(item => {
            item.classList.remove("is-open");
        });
    }

    if (burger) {
        burger.addEventListener("click", function () {
            nav.classList.toggle("active");
            overlay.classList.toggle("active");
        });
    }

    if (overlay) overlay.addEventListener("click", closeMenu);
    if (navClose) navClose.addEventListener("click", closeMenu);

    if (nav) {
        nav.querySelectorAll("a").forEach(link => {
            link.addEventListener("click", function () {
                if (link.classList.contains("nav-parent")) return;
                closeMenu();
            });
        });
    }


    const mq = window.matchMedia("(max-width: 768px)");

    function closeAllSubmenus(except = null) {
        document.querySelectorAll(".nav-item.has-submenu.is-open").forEach(item => {
            if (item !== except) item.classList.remove("is-open");
        });
    }

    document.addEventListener("click", function (e) {

        if (!mq.matches) return;

        const parentLink = e.target.closest(".nav-item.has-submenu > a.nav-parent");
        if (!parentLink) return;

        e.preventDefault();

        const item = parentLink.closest(".nav-item.has-submenu");
        const willOpen = !item.classList.contains("is-open");

        closeAllSubmenus(item);
        item.classList.toggle("is-open", willOpen);

    }, true);

    document.addEventListener("click", function (e) {

        if (!mq.matches) return;
        if (e.target.closest(".nav-item.has-submenu")) return;

        closeAllSubmenus();

    });

    if (mq.addEventListener) {
        mq.addEventListener("change", () => closeAllSubmenus());
    }



    const filterButtons = document.querySelectorAll(".system-filter__btn");
    const searchInput = document.getElementById("systemSearch");
    const cards = document.querySelectorAll(".system-card");

    if (!filterButtons.length || !cards.length) return;

    let activeFilter = "all";
    let query = "";

    function normalize(str) {
        return (str || "").toLowerCase().trim();
    }

    function applyFilters() {

        const q = normalize(query);

        cards.forEach(card => {

            const types = normalize(card.getAttribute("data-type"));
            const title = normalize(card.getAttribute("data-title"));
            const text = normalize(card.textContent);

            const filterMatch =
                activeFilter === "all" ||
                types.split(/\s+/).includes(activeFilter);

            const searchMatch =
                !q ||
                title.includes(q) ||
                text.includes(q);

            if (filterMatch && searchMatch) {
                card.style.display = "";
            } else {
                card.style.display = "none";
            }

        });
    }

    filterButtons.forEach(btn => {

        btn.addEventListener("click", function (e) {

            e.preventDefault();

            filterButtons.forEach(b => b.classList.remove("active"));
            btn.classList.add("active");

            activeFilter = btn.getAttribute("data-filter") || "all";

            applyFilters();

        });

    });

    if (searchInput) {
        searchInput.addEventListener("input", function () {

            query = searchInput.value;

            applyFilters();

        });
    }

    applyFilters();

});
