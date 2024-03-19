document.addEventListener("DOMContentLoaded", function() {
    console.log("test");
    const cards = document.querySelectorAll("main > ul li");
    cards.forEach(function(card) {
        const art = card.firstChild.nextSibling;
        const imageUrl = card.dataset.imageUrl;
        card.style.backgroundColor = "rgba(0,0,0,0.5)";
        card.style.background = `url('${imageUrl}') no-repeat`;
        card.style.backgroundSize = "cover";
        art.style.marginTop = "-60%";
    });
});