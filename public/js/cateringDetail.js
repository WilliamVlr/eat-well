document.addEventListener("DOMContentLoaded", function () {
  const items = document.querySelectorAll(".dropdown-item");
  const button = document.getElementById("dropdownMenuButton");
  const hiddenInput = document.getElementById("selectedPackage");

  items.forEach(item => {
    item.addEventListener("click", function () {
      const selectedText = this.textContent;
      button.textContent = selectedText;
      hiddenInput.value = selectedText;
    });
  });
});



$(document).ready(function() {
  $(".add-button").click(function(e) {
    var accordionItem = $(this).attr("data-tab");
    $("#" + accordionItem)
    .slideToggle()
    .parent()
    .siblings()
    .find(".accordion-content")
    .slideUp();

    $(this).toggleClass("active-title");
    $("#" + accordionItem)
      .parent()
      .siblings()
      .find(".accordion-title")
      .removeClass("active-title");

    // $("i.fa-chevron-down", this).toggleClass("chevron-top");
    // $("#" + accordionItem)
    //   .parent()
    //   .siblings()
    //   .find(".accordion-title i.fa-chevron-down")
    //   .removeClass("chevron-top");
  })
})

$(document).ready(function () {
    const summary = {
        totalItems: 0,
        totalPrice: 0,
        packages: {}
    };

    function updateSummaryDisplay() {
        const pkgCount = Object.keys(summary.packages).length;

        if (pkgCount === 0) {
            $(".order-message").show().text("No Package Selected Yet.");
            $(".package-count, .item-count, .price-total").hide();
        } 
        else if (pkgCount === 1){
            $(".order-message").hide();
            $(".package-count").show().text(`${pkgCount} Package`);
            if(summary.totalItems === 1){
                $(".item-count").show().text(`${summary.totalItems} Item`);
            }
            else{
                $(".item-count").show().text(`${summary.totalItems} Items`);
            }
            $(".price-total").show().text(`Rp. ${summary.totalPrice.toLocaleString("id-ID")},-`);
        }
        else {
            $(".order-message").hide();
            $(".package-count").show().text(`${pkgCount} Packages`); // Sesuaikan teks
            $(".item-count").show().text(`${summary.totalItems} Items`); // Sesuaikan teks
            $(".price-total").show().text(`Rp. ${summary.totalPrice.toLocaleString("id-ID")},-`);
        }
    }

    // Fungsi untuk mengirim data ke server melalui AJAX
    function sendOrderUpdateToServer() {
        $.ajax({
            url: '/update-order-summary', // Ini akan menjadi rute Laravel baru Anda
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'), // Token CSRF Laravel
                packages: summary.packages
            },
            success: function (response) {
                // Perbarui summary sisi klien dengan data dari server
                summary.totalItems = response.totalItems;
                summary.totalPrice = response.totalPrice;
                // Anda juga mungkin ingin memperbarui total per paket individual jika Anda memilikinya
                // di objek summary sisi klien, tetapi untuk saat ini, kita hanya peduli dengan total keseluruhan.

                updateSummaryDisplay(); // Perbarui tampilan dengan total yang dihitung server
            },
            error: function (xhr, status, error) {
                console.error("Kesalahan saat memperbarui ringkasan pesanan:", error);
                // Opsional, tampilkan pesan kesalahan kepada pengguna
            }
        });
    }

    $(".add-button").click(function () {
        const tabId = $(this).attr("data-tab");
        const content = $("#" + tabId);

        $(".add-button").not(this).removeClass("active");
    });

    $(".accordion-content").on("click", ".increment, .decrement", function () {
        const isInc = $(this).hasClass("increment");
        const qtySpan = $(this).siblings(".qty");
        let qty = parseInt(qtySpan.text());
        const price = parseFloat($(this).closest(".item-row").find(".price").data("price"));
        const pkgId = $(this).closest(".accordion-item").find(".accordion-title").data("package-id");
        const pkgAccordionContentId = $(this).closest(".accordion-content").attr("id"); // Ambil ID dari accordion-content
        
        if (isInc) qty++;
        else if (qty > 0) qty--;

        qtySpan.text(qty);

        if (!summary.packages[pkgId]) {
            summary.packages[pkgId] = {
                id: pkgId,
                items: {},
                total: 0 // Total ini akan dihitung di server
            };
        }

        const itemName = $(this).closest(".item-row").find("span:first").text();
        summary.packages[pkgId].items[itemName] = qty;

        // console.log("DEBUG: pkgId saat ini:", pkgId);
        // console.log("DEBUG: itemName saat ini:", itemName);
        // console.log("DEBUG: qty saat ini:", qty);
        // console.log("DEBUG: price dari data-price:", price);
        // console.log("DEBUG: Struktur summary.packages saat ini:", JSON.stringify(summary.packages, null, 2));

        // Hapus item jika qty adalah 0
        if (qty === 0) delete summary.packages[pkgId].items[itemName];

        // Jika sebuah paket tidak memiliki item yang dipilih, hapus dari summary
        if (Object.keys(summary.packages[pkgId]?.items || {}).length === 0) { // Gunakan optional chaining
            delete summary.packages[pkgId];
        }

        // Perbarui label tombol "Add" (bagian ini masih bisa di sisi klien)
        // Temukan 'add-button' yang benar yang terkait dengan paket yang sedang dimodifikasi.
        const addButton = $(`.add-button[data-tab="${pkgAccordionContentId}"]`);
        const addText = addButton.find(".add-text");

        let currentPackageItemCount = 0;
        if (summary.packages[pkgId]) {
             for (let item in summary.packages[pkgId].items) {
                 currentPackageItemCount += summary.packages[pkgId].items[item];
             }
        }


        if (currentPackageItemCount === 0) {
            addText.text("Add");
            addButton.removeClass("active");
        }
        else if (currentPackageItemCount === 1) {
            addText.text(`${currentPackageItemCount} Item`);
            addButton.addClass("active");
        }
        else {
            addText.text(`${currentPackageItemCount} Items`); // Sesuaikan teks
            addButton.addClass("active");
        }

        // Kirim summary yang diperbarui ke server
        sendOrderUpdateToServer();
    });

    // Keadaan awal
    updateSummaryDisplay();
});

  

  document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('pdfModal');
        const iframe = document.getElementById('pdfFrame');
        const closeModal = document.querySelector('.close');

        // Handle semua tombol View
        document.querySelectorAll('.view-menu-text').forEach(viewBtn => {
            viewBtn.addEventListener('click', function () {
                const pdfUrl = this.dataset.pdf;
                iframe.src = pdfUrl;
                modal.style.display = 'flex';
            });
        });

        // Handle semua tombol Download
        document.querySelectorAll('.download-icon').forEach(downloadBtn => {
            downloadBtn.addEventListener('click', function () {
                const pdfUrl = this.dataset.pdf;
                const link = document.createElement('a');
                link.href = pdfUrl;
                link.download = pdfUrl.split('/').pop();
                link.click();
            });
        });

        // Close modal
        closeModal.addEventListener('click', () => {
            modal.style.display = 'none';
            iframe.src = '';
        });

        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
                iframe.src = '';
            }
        });
    });


document.addEventListener('DOMContentLoaded', function () {
    const orderNowBtn = document.querySelector('.number-sold-container');

    if (orderNowBtn) {
        orderNowBtn.addEventListener('click', function () {
            const packagesSection = document.getElementById('packages');
            if (packagesSection) {
                packagesSection.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function() {
  const dropdownMenuButton = document.getElementById('dropdownMenuButton');
  const dropdownItems = document.querySelectorAll('.dropdown-item');
  const mealOptionsList = document.getElementById('mealOptions');
  const displayedPrice = document.getElementById('displayedPrice');
  const selectedPackageInput = document.getElementById('selectedPackage');

  let currentPackageData = {};

  // Fungsi untuk memperbarui pilihan makanan dan harga berdasarkan paket yang dipilih
  function updatePackageDetails(packageElement) {
      const packageId = packageElement.dataset.packageId;
      const packageName = packageElement.textContent.trim();
      const breakfastPrice = packageElement.dataset.breakfastPrice === 'null' ? null : parseFloat(packageElement.dataset.breakfastPrice);
      const lunchPrice = packageElement.dataset.lunchPrice === 'null' ? null : parseFloat(packageElement.dataset.lunchPrice);
      const dinnerPrice = packageElement.dataset.dinnerPrice === 'null' ? null : parseFloat(packageElement.dataset.dinnerPrice);

      // Perbarui teks tombol dropdown
      dropdownMenuButton.textContent = packageName;

      // Perbarui input tersembunyi untuk pengiriman formulir
      selectedPackageInput.value = packageName;

      // Simpan data paket saat ini
      currentPackageData = {
          id: packageId,
          name: packageName,
          breakfastPrice: breakfastPrice,
          lunchPrice: lunchPrice,
          dinnerPrice: dinnerPrice,
      };

      // Hapus pilihan makanan yang ada
      mealOptionsList.innerHTML = '';

      // Tambahkan pilihan Sarapan jika tidak null
      if (breakfastPrice !== null) {
          const li = document.createElement('li');
          li.classList.add('list-group-item');
          li.innerHTML = `
              <input class="form-check-input me-1 meal-checkbox" type="checkbox" value="${breakfastPrice}" id="breakfastCheckbox" checked>
              <label class="form-check-label stretched-link" for="breakfastCheckbox">Breakfast</label>
          `;
          mealOptionsList.appendChild(li);
      }

      // Tambahkan pilihan Makan Siang jika tidak null
      if (lunchPrice !== null) {
          const li = document.createElement('li');
          li.classList.add('list-group-item');
          li.innerHTML = `
              <input class="form-check-input me-1 meal-checkbox" type="checkbox" value="${lunchPrice}" id="lunchCheckbox" checked>
              <label class="form-check-label stretched-link" for="lunchCheckbox">Lunch</label>
          `;
          mealOptionsList.appendChild(li);
      }

      // Tambahkan pilihan Makan Malam jika tidak null
      if (dinnerPrice !== null) {
          const li = document.createElement('li');
          li.classList.add('list-group-item');
          li.innerHTML = `
              <input class="form-check-input me-1 meal-checkbox" type="checkbox" value="${dinnerPrice}" id="dinnerCheckbox" checked>
              <label class="form-check-label stretched-link" for="dinnerCheckbox">Dinner</label>
          `;
          mealOptionsList.appendChild(li);
      }

      // Panggil fungsi untuk memastikan setidaknya satu checkbox aktif
      updateCheckboxStates();
      // Perbarui tampilan harga secara awal
      updateTotalPrice();
  }

  // Fungsi untuk menghitung dan memperbarui total harga
  function updateTotalPrice() {
      let total = 0;
      const checkboxes = mealOptionsList.querySelectorAll('.meal-checkbox:checked');
      checkboxes.forEach(checkbox => {
          total += parseFloat(checkbox.value);
      });

      let formattedTotal;
      if (total >= 1000) {
          formattedTotal = (total / 1000).toFixed(0) + 'k';
      } else {
          formattedTotal = total.toLocaleString('id-ID');
      }
      displayedPrice.textContent = formattedTotal;
  }

  // minimal 1 checkbox yang dicentang, jika hanya satu yang dicentang, nonaktifkan agar tidak bisa di-uncheck
  function updateCheckboxStates() {
      const allCheckboxes = mealOptionsList.querySelectorAll('.meal-checkbox');
      const checkedCheckboxes = mealOptionsList.querySelectorAll('.meal-checkbox:checked');

      if (checkedCheckboxes.length === 1) {
          // Jika hanya satu checkbox yang dicentang, nonaktifkan agar tidak bisa di-uncheck
          checkedCheckboxes[0].disabled = true;
      } else {
          // Jika lebih dari satu dicentang, aktifkan semua checkbox
          allCheckboxes.forEach(checkbox => {
              checkbox.disabled = false;
          });
      }
  }


  // Event listener untuk klik item dropdown
  dropdownItems.forEach(item => {
      item.addEventListener('click', function() {
          updatePackageDetails(this);
      });
  });

  // Event listener untuk perubahan checkbox (didelegasikan ke mealOptionsList)
  mealOptionsList.addEventListener('change', function(event) {
      if (event.target.classList.contains('meal-checkbox')) {
          updateCheckboxStates(); // Panggil fungsi ini setiap kali checkbox berubah
          updateTotalPrice();
      }
  });

  // Inisialisasi dengan paket pertama saat halaman dimuat
  if (dropdownItems.length > 0) {
      updatePackageDetails(dropdownItems[0]);
  }
});