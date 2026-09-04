document.addEventListener("DOMContentLoaded", () => {
    // Pengendalian carian/penapis barang mengikut kategori secara dinamik
    const filterButtons = document.querySelectorAll("[data-filter]");
    const productCards = document.querySelectorAll(".product-grid .card");

    filterButtons.forEach(button => {
        button.addEventListener("click", () => {
            const category = button.getAttribute("data-filter");

            productCards.forEach(card => {
                const cardCategory = card.getAttribute("data-category");
                if (category === "all" || cardCategory === category) {
                    card.style.display = "flex";
                } else {
                    card.style.display = "none";
                }
            });
        });
    });
});