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
    } else {
      $(".order-message").hide();
      $(".package-count").show().text(`${pkgCount} Packages`);
      $(".item-count").show().text(`${summary.totalItems} Items`);
      $(".price-total").show().text(`Rp. ${summary.totalPrice.toLocaleString("id-ID")},-`);
    }
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
    const price = parseInt($(this).closest(".item-row").find(".price").data("price"));
    const pkg = $(this).closest(".accordion-content").attr("id");

    if (isInc) qty++;
    else if (qty > 0) qty--;

    qtySpan.text(qty);

    if (!summary.packages[pkg]) summary.packages[pkg] = { items: {}, total: 0 };

    const itemName = $(this).closest(".item-row").find("span:first").text();
    summary.packages[pkg].items[itemName] = qty;

    // Remove item if qty is 0
    if (qty === 0) delete summary.packages[pkg].items[itemName];
    if (Object.keys(summary.packages[pkg].items).length === 0) delete summary.packages[pkg];

    // Recalculate totals
    summary.totalItems = 0;
    summary.totalPrice = 0;
    for (let key in summary.packages) {
      let items = summary.packages[key].items;
      for (let item in items) {
        let itemQty = items[item];
        let itemPrice = $(`#${key} .item-row:contains(${item}) .price`).data("price");
        summary.totalItems += itemQty;
        summary.totalPrice += itemQty * itemPrice;
      }
    }

    // Update "Add" button label
    const itemCount = Object.keys(summary.packages[pkg]?.items || {}).reduce((acc, key) => {
      return acc + summary.packages[pkg].items[key];
    }, 0);

    const addButton = $(`.add-button[data-tab="${pkg}"]`);
    const addText = addButton.find(".add-text");

    if (itemCount === 0) {
      addText.text("Add");
      addButton.removeClass("active");
    } else {
      addText.text(`${itemCount} Items`);
      addButton.addClass("active");
    }


    updateSummaryDisplay();
  });

  // Initial state
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