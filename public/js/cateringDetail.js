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



  // document.addEventListener("DOMContentLoaded", function () {
  //     const viewMenuText = document.querySelector('.view-menu-text');
  //     const pdfModal = document.getElementById('pdfModal');
  //     const pdfFrame = document.getElementById('pdfFrame');
  //     const closeBtn = document.querySelector('.close');
  //     const downloadBtn = document.querySelector('.download-wrapper');

  //     const pdfUrl = "/asset/catering-detail/pdf/vegetarian-package-menu.pdf";

  //     viewMenuText.addEventListener('click', function () {
  //         pdfFrame.src = pdfUrl;
  //         pdfModal.style.display = 'block';
  //     });

  //     closeBtn.addEventListener('click', function () {
  //         pdfModal.style.display = 'none';
  //         pdfFrame.src = ''; // Reset untuk performance
  //     });

  //     window.addEventListener('click', function (event) {
  //         if (event.target === pdfModal) {
  //             pdfModal.style.display = 'none';
  //             pdfFrame.src = '';
  //         }
  //     });

  //     // Download functionality
  //     downloadBtn.addEventListener('click', function () {
  //         const link = document.createElement('a');
  //         link.href = pdfUrl;
  //         link.download = 'vegetarian-package-menu.pdf';
  //         document.body.appendChild(link);
  //         link.click();
  //         document.body.removeChild(link);
  //     });
  // });



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
