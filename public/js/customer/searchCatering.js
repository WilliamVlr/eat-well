document.addEventListener("DOMContentLoaded", function () {
  const items = document.querySelectorAll(".dropdown-item");
  const addresText = document.getElementById("location-txt");
  const hiddenInput = document.getElementById("selected-location");

  items.forEach(item => {
    item.addEventListener("click", function () {
      const selectedText = this.textContent;
      addresText.textContent = selectedText;
      hiddenInput.value = selectedText;
    });
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

document.querySelectorAll('.btn-fav').forEach(function(btn) {
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        e.preventDefault();
        btn.classList.toggle('favorited');
    });
});