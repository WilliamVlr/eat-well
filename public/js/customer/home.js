/* --------------------------------
    CATERING FAV BUTTON
-------------------------------- */
let favButtons = document.querySelectorAll('.btn-fav');
favButtons.forEach((favbutton) => {
    favbutton.addEventListener('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        const vendorId = favbutton.dataset.vendorId;
        const isFavorited = favbutton.classList.contains('favorited');
        fetch(isFavorited ? `/unfavorite/${vendorId}` : `/favorite/${vendorId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            favbutton.classList.toggle('favorited', data.favorited);
        });
    })
});