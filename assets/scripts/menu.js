document.addEventListener("DOMContentLoaded", function() {
    let icons = document.getElementById("icons");
    let nav = document.getElementById("nav");
    icons.setAttribute("data-content", "☰");
    icons.addEventListener("click", () => {
        nav.classList.toggle("on");
        if (document.querySelector("nav").classList.contains("on")) {
            // If the class "on" is present, change the icon content to "✕".
            icons.setAttribute("data-content", "✕");
        } else {
            // If the class "on" is not present, change the icon content to "☰".
            icons.setAttribute("data-content", "☰");
        }
    })
});