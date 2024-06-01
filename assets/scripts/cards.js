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
        const formatsParagraph = this.closest("li").querySelector(".formats");
        const formatsContent = formatsParagraph.innerHTML;

        // Mettre à jour le contenu de la fenêtre modale avec le contenu du paragraphe
        const modalContent = document.querySelector(".modal-content");
        modalContent.innerHTML = formatsContent + '<button class="close-modal">X</button>';

        // Ajouter un gestionnaire d'événement pour le bouton de fermeture
        const closeButton = modalContent.querySelector(".close-modal");
        closeButton.addEventListener("click", closeModalHandler);
    }

    function closeModalHandler() {
        modalContainer.classList.remove("active");
    }
});