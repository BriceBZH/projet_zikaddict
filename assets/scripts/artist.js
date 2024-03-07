document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll("ul li");
    cards.forEach(function(card) {
        const imageUrl = card.dataset.imageUrl;
        card.style.backgroundImage = `url('${imageUrl}')`;
        // card.style.opacity = 0.6;
    });
});