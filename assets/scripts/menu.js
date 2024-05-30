document.addEventListener("DOMContentLoaded", function() {
    let icons = document.getElementById("icons");
    let nav = document.getElementById("nav");
    icons.setAttribute("data-content", "☰");
    icons.addEventListener("click", () => {
        nav.classList.toggle("active");
        if (document.querySelector("nav").classList.contains("active")) {
            // Si la classe active est présente, changez le contenu de l'icône à "✕"
            icons.setAttribute("data-content", "✕");
        } else {
            // Si la classe active n'est pas présente, changez le contenu de l'icône à "☰"
            icons.setAttribute("data-content", "☰");
        }
    })
});