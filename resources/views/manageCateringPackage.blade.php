<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Catering Manage Menu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" rel="stylesheet" />
  <style>
    body {
      font-family: sans-serif;
      margin: 0;
      background-color: #0b3d2e;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      flex-direction: column;
      color: white;
    }

    .heading-title {
      font-size: 2rem;
      text-align: center;
      color: #ffffff;
      margin-top: 2rem;
      font-weight: 600;
    }

    .text-muted-subheading {
      font-family: 'Roboto', sans-serif;
      color: #ffffff;
      font-size: 1rem;
      text-align: center;
      padding: 0 10px;
    }

    @media (max-width: 576px) {
      .heading-title {
        font-size: 1.5rem;
      }
      .text-muted-subheading {
        font-size: 0.9rem;
      }
    }

    .container {
      padding: 30px;
      background-color: #fff;
      color: #000;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.1);
      text-align: center;
      max-width: 95%;
      margin-top: 20px;
    }

    .modal-lg {
      max-width: 800px;
    }

    .dropzone {
      border: 2px dashed #ccc;
      background: transparent;
      padding: 20px;
      border-radius: 10px;
      margin-top: 20px;
    }

    .carousel-wrapper {
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 16px;
      margin-top: 20px;
    }

    .carousel-item {
      width: 180px;
      height: 120px;
      border: 2px solid #ccc;
      border-radius: 10px;
      overflow: hidden;
      position: relative;
      background-color: #f0f0f0;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 0;
    }

    .carousel-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .remove-button {
      position: absolute;
      bottom: 6px;
      right: 6px;
      background: #28a745;
      border: none;
      color: white;
      font-size: 14px;
      padding: 4px 8px;
      border-radius: 5px;
      cursor: pointer;
    }

    .add-button {
      width: 180px;
      height: 120px;
      border: 2px dashed #aaa;
      border-radius: 10px;
      background-color: #fff;
      color: #555;
      font-size: 32px;
      font-weight: bold;
      cursor: pointer;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    input[type="file"] {
      display: none;
    }

    .dropzone {
        border: 2px dashed #aaa !important;
        background-color: #fafafa;
        border-radius: 10px;
        padding: 30px;
        text-align: center;
        color: #777;
        font-weight: 500;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 120px;
        transition: background-color 0.3s;
    }

    .dropzone:hover {
        background-color: #f0f0f0;
    }

    /* Untuk teks "Drop here..." */
    .dropzone .dz-message {
    font-size: 16px;
    color: #777;
    }

   @media (min-width: 308px) {
    .modal-dialog {
        margin: 1.75rem auto;
    }

    .modal-content {
        border-radius: 15px;
        padding: 20px;
        max-width: 80%; /* agar tidak terlalu mepet */
        margin: auto;
    }
    }

    @media (max-width: 768px) {
        .modal-content {
            padding: 1rem;
        }
    }

    </style>
</head>
<body>
  <div class="heading-title">Find your Package</div>
  <div class="text-muted-subheading">You can edit our previous and add your new package to your catering.</div>

  <div class="container mt-5">
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#packageModal" onclick="openAddModal()">Add Package</button>

    <div class="table-responsive">
      <table class="table table-bordered">
        <thead class="table-dark">
          <tr>
            <th>No</th>
            <th>Package Name</th>
            <th>Category</th>
            <th>Cuisine Type</th>
            <th>Breakfast Price</th>
            <th>Lunch Price</th>
            <th>Dinner Price</th>
            <th>Breakfast Calory</th>
            <th>Lunch Calory</th>
            <th>Dinner Calory</th>
            <th>File Menu</th>
            <th>Package Image</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="packageTable">
          <tr>
            <td>1</td>
            <td>Healthy Delight</td>
            <td>Halal</td>
            <td>Indonesian</td>
            <td>Rp25.000</td>
            <td>Rp35.000</td>
            <td>Rp30.000</td>
            <td>300 kcal</td>
            <td>500 kcal</td>
            <td>450 kcal</td>
            <td><a href="#">menu_healthy.pdf</a></td>
            <td><a href="#">packageA.png</a></td>
            <td>
              <button class="btn btn-warning btn-sm" onclick="openEditModal()">Edit</button>
              <button class="btn btn-danger btn-sm">Delete</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="packageModal" tabindex="-1" aria-labelledby="packageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <form id="packageForm">
          <div class="modal-header">
            <h5 class="modal-title" id="packageModalLabel">Add Package</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <!-- form fields -->
            <div class="mb-3">
              <label for="packageName" class="form-label">Package Name</label>
              <input type="text" class="form-control" id="packageName" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Select Category</label>
              <select class="form-select" id="category">
                <option value="Vegan">Vegan</option>
                <option value="Gluten-Free">Gluten-Free</option>
                <option value="Halal">Halal</option>
              </select>
            </div>

            <div class="mb-3">
              <label class="form-label">Cuisine Type</label>
              <div>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="selectCuisine('Indonesian')">Indonesian</button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="selectCuisine('Chinese')">Chinese</button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="selectCuisine('Japanese')">Japanese</button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="selectCuisine('Korean')">Korean</button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="selectCuisine('Western')">Western</button>
                <button type="button" class="btn btn-outline-secondary btn-sm" onclick="selectCuisine('Fusion')">Fusion</button>
              </div>
              <input type="hidden" id="cuisineType">
            </div>

            <div class="row">
              <div class="col">
                <label for="breakfastPrice" class="form-label">Breakfast Price</label>
                <input type="number" class="form-control" id="breakfastPrice">
              </div>
              <div class="col">
                <label for="lunchPrice" class="form-label">Lunch Price</label>
                <input type="number" class="form-control" id="lunchPrice">
              </div>
              <div class="col">
                <label for="dinnerPrice" class="form-label">Dinner Price</label>
                <input type="number" class="form-control" id="dinnerPrice">
              </div>
            </div>

            <div class="row mt-3">
              <div class="col">
                <label for="breakfastCal" class="form-label">Breakfast Calory</label>
                <input type="number" class="form-control" id="breakfastCal">
              </div>
              <div class="col">
                <label for="lunchCal" class="form-label">Lunch Calory</label>
                <input type="number" class="form-control" id="lunchCal">
              </div>
              <div class="col">
                <label for="dinnerCal" class="form-label">Dinner Calory</label>
                <input type="number" class="form-control" id="dinnerCal">
              </div>
            </div>

           <form id="packageForm">
            <div class="dropzone" id="menuDropzone"></div>
            <div class="dropzone" id="imageDropzone"></div>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-success">Save Package</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="heading-title">Add Your Package Preview</div>
  <div class="text-muted-subheading">We suggest adding the landscape version and including at least 3 preview images and 5 preview max.</div>

  <div class="container">
    <div class="carousel-wrapper" id="carousel-wrapper"></div>
    <input type="file" id="imageInput" accept="image/*" />
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

  <script>
    function selectCuisine(cuisine) {
      document.getElementById('cuisineType').value = cuisine;
    }

    function openAddModal() {
      document.getElementById('packageModalLabel').innerText = 'Add Package';
      document.getElementById('packageForm').reset();
    }

    function openEditModal() {
      document.getElementById('packageModalLabel').innerText = 'Edit Package';
      const modal = new bootstrap.Modal(document.getElementById('packageModal'));
      modal.show();
    }


    // Inisialisasi Dropzone manual karena tidak lagi menggunakan <form action="...">
    new Dropzone("#menuDropzone", {
    url: "/upload",
    acceptedFiles: ".pdf",
    maxFilesize: 5,
    maxFiles: 1,
    dictDefaultMessage: "Drop your PDF menu here or click to upload",
    });

    new Dropzone("#imageDropzone", {
    url: "/upload",
    acceptedFiles: ".png",
    maxFilesize: 10,
    maxFiles: 1,
    dictDefaultMessage: "Drop PNG image here or click to upload",
    init: function () {
        this.on("success", function (file, response) {
        console.log("Image uploaded successfully");
        });
    }
    });


    const carousel = document.getElementById("carousel-wrapper");
    const imageInput = document.getElementById("imageInput");
    const MAX_IMAGES = 5;

    const dummyImages = [
      "asset/catering/homePage/breakfastPreview.png",
      "asset/catering/homePage/lunchPreview.png",
      "asset/catering/homePage/dinnerPreview.png"
    ];

    function createImageItem(src) {
      const item = document.createElement("div");
      item.className = "carousel-item";
      const img = document.createElement("img");
      img.src = src;

      const button = document.createElement("button");
      button.className = "remove-button";

      function updateButton() {
        const total = carousel.querySelectorAll(".carousel-item").length;
        button.textContent = total === 3 ? "↻" : "✖";
      }

      updateButton();

      button.addEventListener("click", () => {
        if (button.textContent === "↻") {
          imageInput.dataset.replaceTarget = src;
          imageInput.click();
        } else {
          item.remove();
          renderAddButtons();
        }
      });

      item.appendChild(img);
      item.appendChild(button);
      return item;
    }

    function createAddButton() {
      const addBtn = document.createElement("div");
      addBtn.className = "add-button";
      addBtn.textContent = "+";
      addBtn.addEventListener("click", () => {
        delete imageInput.dataset.replaceTarget;
        imageInput.click();
      });
      return addBtn;
    }

    function renderAddButtons() {
      const existingAdd = carousel.querySelector(".add-button");
      if (existingAdd) existingAdd.remove();

      carousel.querySelectorAll(".carousel-item .remove-button").forEach(btn => {
        const total = carousel.querySelectorAll(".carousel-item").length;
        btn.textContent = total === 3 ? "↻" : "✖";
      });

      const totalImages = carousel.querySelectorAll(".carousel-item").length;
      if (totalImages < MAX_IMAGES) {
        const addBtn = createAddButton();
        carousel.appendChild(addBtn);
      }
    }

    imageInput.addEventListener("change", (event) => {
      const file = event.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = (e) => {
        const src = e.target.result;
        const replaceTarget = imageInput.dataset.replaceTarget;

        if (replaceTarget) {
          const items = carousel.querySelectorAll(".carousel-item img");
          items.forEach(img => {
            if (img.src === replaceTarget) {
              img.src = src;
            }
          });
        } else {
          const item = createImageItem(src);
          const addButton = carousel.querySelector(".add-button");
          if (addButton) {
            carousel.insertBefore(item, addButton);
          } else {
            carousel.appendChild(item);
          }
        }

        renderAddButtons();
      };

      reader.readAsDataURL(file);
      imageInput.value = "";
    });

    dummyImages.forEach((src) => {
      const item = createImageItem(src);
      carousel.appendChild(item);
    });
    renderAddButtons();
  </script>
</body>
</html>
