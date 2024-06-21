document.addEventListener("DOMContentLoaded", function() {
    // admin page
    let menuLi = document.querySelectorAll('.menu-li');
    let tables = document.querySelectorAll('.menu-table');

    menuLi.forEach(function(li) {
        li.addEventListener('click', function() {
            let target = this.getAttribute('data-target');
            tables.forEach(function(table) {
                if (table.id === target) {
                    table.classList.toggle("hidden");
                }
            });
            let icon = this.querySelector('#li_icons');
                if (icon.textContent === '⊻') {
                    icon.textContent = '⊼';
                } else {
                    icon.textContent = '⊻';
                }
        });
    });
});