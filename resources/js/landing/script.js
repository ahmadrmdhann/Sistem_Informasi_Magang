document.addEventListener("DOMContentLoaded", function () {
    const btn = document.getElementById("mobile-menu-button");
    const menu = document.getElementById("mobile-menu");
    if (btn && menu) {
        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
        });
    }
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            const href = this.getAttribute("href");
            if (href.length > 1 && document.querySelector(href)) {
                e.preventDefault();
                document
                    .querySelector(href)
                    .scrollIntoView({ behavior: "smooth" });
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const group = document.querySelector(".group");
    const btn = group?.querySelector("button");
    const dropdown = group?.querySelector(".absolute");
    if (btn && dropdown && group) {
        btn.addEventListener("click", function (e) {
            e.preventDefault();
            group.classList.toggle("open");
        });
        document.addEventListener("click", function (e) {
            if (!group.contains(e.target)) {
                group.classList.remove("open");
            }
        });
    }
});
