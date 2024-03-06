document.addEventListener("DOMContentLoaded", function() {
    const cards = document.querySelectorAll("ul li");
    cards.forEach(function(card) {
        // alert(card.dataset.imageUrl);
        const imageUrl = card.dataset.imageUrl;
        card.style.backgroundImage = `url('${imageUrl}')`;
    });

    const test = document.querySelector(".test");
    test.style.backgroundImage = "url('assets/imgs/bob_marley.png')";
});