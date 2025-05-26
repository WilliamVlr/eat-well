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

