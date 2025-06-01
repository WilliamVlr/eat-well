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