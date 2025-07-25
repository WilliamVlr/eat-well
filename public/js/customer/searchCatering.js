document.addEventListener("DOMContentLoaded", function () {
//   const items = document.querySelectorAll(".dropdown-item");
  const addresText = document.getElementById("location-txt");
  const hiddenInput = document.getElementById("selected-address-for-vendor");

  document.querySelector('.location-dropdown .dropdown-menu').addEventListener('click', function(e) {
        const item = e.target.closest('.dropdown-item.location-text');
        if (item) {
            e.preventDefault();

            const selectedText = item.textContent.trim(); // Gunakan trim() untuk membersihkan spasi
            const selectedAddressId = item.dataset.addressId; // Ambil data-address-id

            addresText.textContent = selectedText; // Update teks yang terlihat
            hiddenInput.value = selectedAddressId; // Update hidden input

            // console.log('Dropdown item clicked.');
            // console.log('Selected address ID:', selectedAddressId);
            // console.log('Updated location text:', selectedText);

            // Perbarui URL saat lokasi dipilih
            const url = new URL(window.location.href);
            url.searchParams.set('address_id', selectedAddressId);
            window.location.href = url.toString();
        }
    });

});

document.querySelectorAll('input[name="rating"]').forEach(function(radio) {
    radio.addEventListener('mousedown', function(e) {
        if (this.checked) {
            // Allow unchecking by clearing after click
            this.wasChecked = true;
        } else {
            this.wasChecked = false;
        }
    });
    radio.addEventListener('click', function(e) {
        if (this.wasChecked) {
            this.checked = false;
            // Optional: trigger change event if you rely on it
            this.dispatchEvent(new Event('change'));
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var openBtn = document.getElementById('openFilterBtn');
    var closeBtn = document.getElementById('closeFilterBtn');
    var popup = document.getElementById('filterPopup');
    if(openBtn && closeBtn && popup) {
        openBtn.addEventListener('click', function() {
            popup.classList.add('active');
            document.body.style.overflow = 'hidden';
        });
        closeBtn.addEventListener('click', function() {
            popup.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
});

// Allow unchecking sort radio button when clicked again
document.querySelectorAll('input[name="sort"]').forEach(function(radio) {
    radio.addEventListener('mousedown', function(e) {
        if (this.checked) {
            this.wasChecked = true;
        } else {
            this.wasChecked = false;
        }
    });
    radio.addEventListener('click', function(e) {
        if (this.wasChecked) {
            this.checked = false;
            this.dispatchEvent(new Event('change'));
        }
    });
});