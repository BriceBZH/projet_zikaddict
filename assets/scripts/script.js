document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll("main > ul li");
    cards.forEach(function(card) {
        const art = card.firstChild.nextSibling;
        const imageUrl = card.dataset.imageUrl;
        card.style.backgroundColor = "rgba(0,0,0,0.5)";
        card.style.backgroundImage = `url('${imageUrl}')`;
        art.style.marginTop = "-60%";
    });
});