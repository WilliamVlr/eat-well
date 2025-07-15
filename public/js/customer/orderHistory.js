document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".rating-icon-list").forEach(function (list) {
        const stars = list.querySelectorAll(".star-icon");
        let selected = -1; // Store the last clicked index

        stars.forEach((star, idx) => {
            // Click event
            star.addEventListener("click", function () {
                selected = idx;
                updateStars(idx);
                showRateReviewModal(idx + 1);
            });

            // Hover event
            star.addEventListener("mouseenter", function () {
                updateStars(idx);
            });
        });

        // Mouse leave event (on the whole list)
        list.addEventListener("mouseleave", function () {
            updateStars(selected);
        });

        function updateStars(activeIdx) {
            stars.forEach((s, i) => {
                if (i <= activeIdx) {
                    s.classList.add("choosen");
                } else {
                    s.classList.remove("choosen");
                }
            });
        }
    });
});

// Dummy modal function, replace with your modal logic
function showRateReviewModal(rating) {
    alert("You rated: " + rating + " star(s)");
}

const modal = document.getElementById("cancelModal");
const cancelForm = document.getElementById("cancelForm");
const closeBtn = document.getElementById("closeModalBtn");

document.querySelectorAll(".open-cancel-modal").forEach((button) => {
    button.addEventListener("click", function () {
        const orderId = this.getAttribute("data-order-id");
        // Construct full action URL matching route /orders/{id}/cancel
        const cancelUrl = `/orders/${orderId}/cancel`;
        cancelForm.setAttribute("action", cancelUrl);
        modal.classList.remove("hidden");
    });
});

closeBtn.addEventListener("click", function () {
    modal.classList.add("hidden");
    cancelForm.removeAttribute("action"); // Clean up
});
