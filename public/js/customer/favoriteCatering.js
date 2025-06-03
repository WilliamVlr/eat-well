/* --------------------------------
    CATERING FAV BUTTON
-------------------------------- */
let favButtons = document.querySelectorAll('span.favorite-icon');
favButtons.forEach((favbutton) => {
    favbutton.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        favbutton.classList.toggle('active');
    })
} )