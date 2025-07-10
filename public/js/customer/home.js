document.addEventListener("DOMContentLoaded", () => {
    let favButtons = document.querySelectorAll(".btn-fav");

    favButtons.forEach((favButton) => {
        favButton.addEventListener("click", function (e) {
            e.preventDefault();
            e.stopPropagation();

            const vendorId = favButton.dataset.vendorId;
            console.log(vendorId);
            const isFavorited = favButton.classList.contains("favorited");
            const url = isFavorited
                ? `/unfavorite/${vendorId}`
                : `/favorite/${vendorId}`;

            fetch(url, {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector(
                        'meta[name="csrf-token"]'
                    ).content,
                    Accept: "application/json",
                },
            })
                .then((res) => res.json())
                .then((data) => {
                    // Toggle class
                    favButton.classList.toggle("favorited", data.favorited);

                    // Add or remove from favorite section dynamically
                    if (data.favorited) {
                        addToFavoriteSection(vendorId);
                    } else {
                        removeFromFavoriteSection(vendorId);
                    }
                });
        });
    });

    function addToFavoriteSection(vendorId) {
        // Avoid duplicates
        if (document.getElementById(`fav-card-${vendorId}`)) return;

        fetch(`/card-vendor/${vendorId}`)
            .then((res) => res.text())
            .then((html) => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, "text/html");

                // Grab only the card link
                const card = doc.querySelector("a.catering-card-link");
                if (!card) return;

                // Create the list item container
                const li = document.createElement("li");
                li.id = `fav-card-${vendorId}`;
                li.appendChild(card);

                // Append to the favorite carousel
                const ul = document.querySelector(
                    ".fav-catering-container ul.carousel-product-list"
                );
                if (ul) {
                    ul.appendChild(li);
                }

                // Make sure the section is visible
                document
                    .querySelector(".fav-catering-container")
                    ?.classList.remove("d-none");
            })
            .catch((err) => console.error("Failed to load vendor card:", err));
    }

    function removeFromFavoriteSection(vendorId) {
        console.log("Kepanggil");
        const card = document.getElementById(`fav-card-${vendorId}`);
        if (card) {
            card.remove();
            console.log("masuk");
        }

        // Optionally hide section if now empty
        const ul = document.querySelector(
            ".fav-catering-container ul.carousel-product-list"
        );
        if (ul && ul.children.length === 0) {
            document
                .querySelector(".fav-catering-container")
                ?.classList.add("d-none");
        }
    }
});
