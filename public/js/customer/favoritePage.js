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
            // Remove the entire column if unfavorited
            if (!data.favorited) {
                // Find the closest column (adjust selector if needed)
                let col = favbutton.closest('.col-md-6, .col-xl-4, .p-2');
                if (col) {
                    col.remove();
                }
                // If no more cards, show the empty state
                const row = document.querySelector('.fav-vendor-container .row');
                if (row && row.children.length === 0) {
                    const emptyDiv = document.createElement('div');
                    emptyDiv.className = 'd-flex flex-row justify-content-center';
                    emptyDiv.innerHTML = `<img src="/asset/empty-favorites.png" class="rounded-4" alt="No Favorite vendors" width="250px" height="250px">`;
                    row.parentNode.appendChild(emptyDiv);
                    row.remove();
                }
            }
        });
    })
});