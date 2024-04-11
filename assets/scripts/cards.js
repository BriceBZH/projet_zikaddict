document.addEventListener("DOMContentLoaded", function() {
    //affichage cards
    const cards = document.querySelectorAll("main > ul li");
    cards.forEach(function(card) {
        const art = card.firstChild.nextSibling;
        const imageUrl = card.dataset.imageUrl;
        // card.style.backgroundColor = "rgba(0,0,0,0.5)";
        card.style.background = `url('${imageUrl}') no-repeat`;
        card.style.backgroundSize = "cover";
        // art.style.marginTop = "-40%";
    });
    //selection du format de l'album de la collection
    document.addEventListener("click", function(e){
        const paragraphs = document.querySelectorAll('.formats');
        paragraphs.forEach(function(paragraph) {
            paragraph.style.display = 'none';
        });
        let element = e.target;
        let target = element.dataset.target;
        if (target) {
            const el = document.querySelector("." + target);
            if (el) {
                if (el.style.display === 'block') {
                    el.style.display = 'none';
                } else {
                    el.style.display = 'block';
                }
            }
        }
    });
});