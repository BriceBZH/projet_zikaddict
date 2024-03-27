document.addEventListener("DOMContentLoaded", function() {
    // const cards = document.querySelectorAll("main > ul li");
    // cards.forEach(function(card) {
    //     const art = card.firstChild.nextSibling;
    //     const imageUrl = card.dataset.imageUrl;
    //     card.style.backgroundColor = "rgba(0,0,0,0.5)";
    //     card.style.background = `url('${imageUrl}') no-repeat`;
    //     card.style.backgroundSize = "cover";
    //     art.style.marginTop = "-60%";
    // });
    // page admin
    let menuLi = document.querySelectorAll('.menu-li');
    let tables = document.querySelectorAll('.menu-table');

    menuLi.forEach(function(li) {
        li.addEventListener('click', function() {
            let target = this.getAttribute('data-target');
            tables.forEach(function(table) {
                if (table.id === target) {
                    if (table.style.display === 'block') {
                        table.style.display = 'none';
                    } else {
                        table.style.display = 'block';
                    }
                } else {
                    table.style.display = 'none';
                }
            });
        });
    });
});