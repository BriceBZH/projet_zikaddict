document.addEventListener("DOMContentLoaded", function() {
    let icons = document.getElementById("icons");
    let nav = document.getElementById("nav");
    icons.setAttribute("data-content", "☰");
    icons.addEventListener("click", () => {
        nav.classList.toggle("on");
        if (document.querySelector("nav").classList.contains("on")) {
            // Si la classe on est présente, changez le contenu de l'icône à "✕"
            icons.setAttribute("data-content", "✕");
        } else {
            // Si la classe on n'est pas présente, changez le contenu de l'icône à "☰"
            icons.setAttribute("data-content", "☰");
        }
    })
});