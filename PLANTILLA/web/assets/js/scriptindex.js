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

});

document.addEventListener("DOMContentLoaded", function () {
    var root = document.documentElement;
    var btn = document.getElementById("themeToggle");
    var icon = document.getElementById("themeIcon");
    if (!btn || !icon) return;
 
    function applyTheme(theme) {
        if (theme === "dark") {
            root.setAttribute("data-theme", "dark");
            icon.classList.remove("bx-moon");
            icon.classList.add("bx-sun");
        } else {
            root.removeAttribute("data-theme");
            icon.classList.remove("bx-sun");
            icon.classList.add("bx-moon");
        }
    }
 
    var saved = localStorage.getItem("theme") || "light";
    applyTheme(saved);
 
    btn.addEventListener("click", function () {
        var current = root.getAttribute("data-theme") === "dark" ? "dark" : "light";
        var next = current === "dark" ? "light" : "dark";
        applyTheme(next);
        localStorage.setItem("theme", next);
    });
});
 