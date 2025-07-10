document.addEventListener('DOMContentLoaded', function() {
    const input = document.getElementById('vendorLogoInput');
    const preview = document.getElementById('vendorLogoPreview');
    const uploadBtn = document.getElementById('logoUploadBtn');
    if(uploadBtn && input){
        uploadBtn.addEventListener('click', function(e){
            e.preventDefault();
            input.click();
        });
    }
    if (input && preview) {
        input.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    preview.src = ev.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }
});