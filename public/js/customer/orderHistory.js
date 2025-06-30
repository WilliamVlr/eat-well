document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.rating-icon-list').forEach(function(list) {
        const stars = list.querySelectorAll('.star-icon');
        let selected = -1; // Store the last clicked index

        stars.forEach((star, idx) => {
            // Click event
            star.addEventListener('click', function() {
                selected = idx;
                updateStars(idx);
                showRateReviewModal(idx + 1);
            });

            // Hover event
            star.addEventListener('mouseenter', function() {
                updateStars(idx);
            });
        });

        // Mouse leave event (on the whole list)
        list.addEventListener('mouseleave', function() {
            updateStars(selected);
        });

        function updateStars(activeIdx) {
            stars.forEach((s, i) => {
                if (i <= activeIdx) {
                    s.classList.add('choosen');
                } else {
                    s.classList.remove('choosen');
                }
            });
        }
    });
});

// Dummy modal function, replace with your modal logic
function showRateReviewModal(rating) {
    alert('You rated: ' + rating + ' star(s)');
}