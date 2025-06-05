document.querySelectorAll('.menu-link').forEach(link => {
    link.addEventListener('click', function(e) {
        document.querySelectorAll('.menu-link').forEach(l => l.classList.remove('active'));
        this.classList.add('active');
        // e.preventDefault(); // Uncomment if you don't want the link to navigate
    });
});