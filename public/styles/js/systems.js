document.addEventListener("DOMContentLoaded", function () {

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

            card.style.display = (filterMatch && searchMatch) ? "" : "none";

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
