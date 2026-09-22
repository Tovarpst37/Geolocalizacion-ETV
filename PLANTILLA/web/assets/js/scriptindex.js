$(function () {
    $("#toggleBtn").on("click", function () {
        $("#sideMenu").toggleClass("collapsed");

        if ($("#sideMenu").hasClass("collapsed")) {
            $(".nav-item.open").removeClass("open");
        }
    });

    $(".nav-item").each(function () {
        const $item = $(this);
        const $link = $item.children(".nav-link");
        const $submenu = $item.children(".submenu");

        if ($submenu.length === 0) return;

        $link.on("click", function (e) {
            e.preventDefault();

            if ($("#sideMenu").hasClass("collapsed")) {
                $("#sideMenu").removeClass("collapsed");
            }

            const isOpen = $item.hasClass("open");

            $(".nav-item.open").not($item).removeClass("open");

            $item.toggleClass("open", !isOpen);
        });
    });

    $("#Buscar").on("keyup", function () {
        const query = $(this).val().toLowerCase().trim();

        $(".nav-item").each(function () {
            const $item = $(this);
            const itemText = $item.find("> .nav-link .text").text().toLowerCase();
            const $subItems = $item.find(".submenu li");
            let hasMatch = itemText.includes(query);

            $subItems.each(function () {
                const subText = $(this).find(".sub-item").text().toLowerCase();
                const matches = query === "" || subText.includes(query);
                $(this).toggle(matches);
                if (subText.includes(query)) hasMatch = true;
            });

            if (query === "") {
                $item.show().removeClass("open");
            } else {
                $item.toggle(hasMatch).toggleClass("open", hasMatch);
            }
        });

        $(".menu-tag").each(function () {
            const $group = $(this).nextUntil(".menu-tag", "ul");
            const anyVisible = $group.find(".nav-item:visible").length > 0;
            $(this).toggle(query === "" || anyVisible);
        });
    });
});

(function () {
    function initThemeToggle() {
        const root = document.documentElement;
        const btn = document.getElementById("themeToggle");
        const icon = document.getElementById("themeIcon");
        if (!btn || !icon) return;

        function syncIcon() {
            const isDark = root.getAttribute("data-theme") === "dark";
            icon.classList.toggle("bx-sun", isDark);
            icon.classList.toggle("bx-moon", !isDark);
        }

        const saved = localStorage.getItem("theme") || "light";
        if (saved === "dark") {
            root.setAttribute("data-theme", "dark");
        } else {
            root.removeAttribute("data-theme");
        }
        syncIcon();

        btn.addEventListener("click", function () {
            const isDark = root.getAttribute("data-theme") === "dark";
            const next = isDark ? "light" : "dark";

            if (next === "dark") {
                root.setAttribute("data-theme", "dark");
            } else {
                root.removeAttribute("data-theme");
            }
            localStorage.setItem("theme", next);
            syncIcon();
        });
    }

    if (document.readyState === "loading") {
        document.addEventListener("DOMContentLoaded", initThemeToggle);
    } else {
        initThemeToggle();
    }
})();