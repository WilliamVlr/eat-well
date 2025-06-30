document.addEventListener('DOMContentLoaded', function () {
    var carousel = document.getElementById('cdsCarousel');
    if (!carousel) return;

    // Ensure Bootstrap Carousel is initialized
    var bsCarousel = bootstrap.Carousel.getOrCreateInstance(carousel);

    var indicatorBtns = document.querySelectorAll('.cds-carousel-indicator-btn');

    // Listen for carousel slide event
    carousel.addEventListener('slid.bs.carousel', function (event) {
        var idx = event.to;
        indicatorBtns.forEach(function(btn, i) {
            if (i === idx) {
                btn.classList.add('active');
                btn.setAttribute('aria-current', 'true');
            } else {
                btn.classList.remove('active');
                btn.setAttribute('aria-current', 'false');
            }
        });
    });

    // Also handle click on indicators to slide carousel
    indicatorBtns.forEach(function(btn, i) {
        btn.addEventListener('click', function() {
            bsCarousel.to(i);
        });
    });
});