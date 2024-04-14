document.addEventListener("DOMContentLoaded", function() {
    //affichage cards
    const cards = document.querySelectorAll("main > ul li");
    cards.forEach(function(card) {
        const art = card.firstChild.nextSibling;
        const imageUrl = card.dataset.imageUrl;
        card.style.background = `url('${imageUrl}') no-repeat`;
        card.style.backgroundSize = "cover";
    });

    //selection du format de l'album de la collection
    const modalContainer = document.querySelector(".modal-container");
    const modalTriggers = document.querySelectorAll(".modal-trigger");

    modalTriggers.forEach(trigger => trigger.addEventListener("click", toggleModal));

    function toggleModal() {
        modalContainer.classList.toggle("active");
        // Récupérer le contenu du paragraphe
        const formatsParagraph = this.parentElement.querySelector(".formats");
        const formatsContent = formatsParagraph.innerHTML;

        // Mettre à jour le contenu de la fenêtre modale avec le contenu du paragraphe
        const modalContent = document.querySelector(".modal-content");
        modalContent.innerHTML = formatsContent;
    }
});