<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Catering Manage Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
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
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
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
                max-width: 80%;
                /* agar tidak terlalu mepet */
                margin: auto;
            }
        }

        @media (max-width: 768px) {
            .modal-content {
                padding: 1rem;
            }
        }

        td {
            vertical-align: middle;
        }

        th {
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <div class="heading-title">Find your Package</div>
    <div class="text-muted-subheading">You can edit our previous and add your new package to your catering.</div>


    <div class="container mt-5">
        <div class="d-flex justify-content-between mb-3">

            <div class="w-50">
                <label for="import" class="form-label">Import</label>
                <input type="file" class="form-control" id="import" accept=".csv, .xlsx, .xls">
                <div class="form-text">Format kolom: name, category, cuisine_type, breakfast_price, lunch_price,
                    dinner_price, average_calory, file_menu, package_image</div>
            </div>
        </div>

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
                        <th>Average Calory</th>
                        <th>File Menu</th>
                        <th>Package Image</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody id="packageTable">
                    @foreach ($packages as $package)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $package->name }}</td>
                            <td>{{ $package->category->categoryName ?? 'N/A' }}</td>
                            <td>
                                @foreach ($package->cuisineTypes as $type)
                                    {{ $type->cuisineName }},
                                @endforeach
                            </td>
                            <td>Rp{{ number_format($package->breakfastPrice ?? 0, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($package->lunchPrice ?? 0, 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($package->dinnerPrice ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $package->averageCalories }} kcal</td>
                            <td>
                                @if ($package->menuPDFPath)
                                    <a href="{{ asset('asset/menus/' . $package->menuPDFPath) }}"
                                        target="_blank">{{ $package->menuPDFPath }}</a>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if ($package->imgPath)
                                    <img src="{{ asset('asset/menus/' . $package->imgPath) }}"
                                        alt="{{ $package->name }}" width="100">
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm" data-package="{!! htmlspecialchars(
                                    json_encode([
                                        'id' => $package->packageId,
                                        'name' => $package->name,
                                        'categoryId' => $package->categoryId,
                                        'breakfastPrice' => $package->breakfastPrice,
                                        'lunchPrice' => $package->lunchPrice,
                                        'dinnerPrice' => $package->dinnerPrice,
                                        'averageCalories' => $package->averageCalories,
                                        'cuisines' => $package->cuisineTypes->pluck('cuisineId'),
                                    ]),
                                    ENT_QUOTES,
                                    'UTF-8',
                                ) !!}"
                                    onclick="handleEditClick(this)">
                                    <i class="bi bi-pencil-fill"></i>
                                </button>

                                <button class="btn btn-danger btn-sm"
                                    onclick="deletePackage({{ $package->packageId }})" title="Delete">
                                    <i class="bi bi-trash-fill"></i>
                                </button>
        </div>
        </td>
        </tr>
        @endforeach
        </tbody>
        </table>
    </div>
    <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#packageModal"
        onclick="openAddModal()">Add Package</button>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="packageModal" tabindex="-1" aria-labelledby="packageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form id="packageForm" method="post" action="{{ route('packages.store') }}"
                    enctype="multipart/form-data">
                    @csrf
                    {{-- @method('put') --}}
                    <div class="modal-header">
                        <h5 class="modal-title" id="packageModalLabel">Add Package</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excelUpload" class="form-label">Upload Excel / CSV</label>
                            <input type="file" class="form-control" id="excelUpload" accept=".csv, .xlsx, .xls">
                        </div>

                        <!-- form fields -->
                        <div class="mb-3">
                            <label for="packageName" class="form-label">Package Name</label>
                            <input type="text" name="name" class="form-control" id="packageName" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Select Category</label>
                            <select class="form-select" name="categoryId" id="category">
                                <option value="1">Vegetarian</option>
                                <option value="2">Gluten-Free</option>
                                <option value="3">Halal</option>
                                <option value="4">Low Carb</option>
                                <option value="5">Low Calorie</option>
                                <option value="6">Organic</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Cuisine Type</label>
                            <div id="cuisine-buttons">
                                @foreach ($cuisines as $cuisine)
                                    <button type="button" class="btn btn-outline-secondary btn-sm"
                                        onclick="toggleCuisine({{ $cuisine->cuisineId }}, event)">
                                        {{ $cuisine->cuisineName }}
                                    </button>
                                @endforeach
                            </div>

                            <!-- Hidden inputs akan dimasukkan ke sini -->
                            <div id="cuisineInputs"></div>

                        </div>

                        <div class="row">
                            <div class="col">
                                <label for="breakfastPrice" class="form-label">Breakfast Price</label>
                                <input type="number" name="breakfastPrice" class="form-control"
                                    id="breakfastPrice">
                            </div>
                            <div class="col">
                                <label for="lunchPrice" class="form-label">Lunch Price</label>
                                <input type="number" name="lunchPrice" class="form-control" id="lunchPrice">
                            </div>
                            <div class="col">
                                <label for="dinnerPrice" class="form-label">Dinner Price</label>
                                <input type="number" name="dinnerPrice" class="form-control" id="dinnerPrice">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col">
                                <label for="averageCalories" class="form-label">Average Calory</label>
                                <input type="number" name="averageCalories" class="form-control"
                                    id="averageCalories">
                            </div>
                        </div>

                        <div class="dropzone" id="menuDropzone">
                            <input type="file" name="menuPDFPath" id="menuPDFPath">
                        </div>
                        <div class="dropzone" id="imageDropzone">
                            <input type="file" name="imgPath" id="imgPath">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success" value="Save Package">Save Package</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    </div>

    <div class="heading-title">Add Your Package Preview</div>
    <div class="text-muted-subheading">We suggest adding the landscape version and including at least 3 preview images
        and 5 preview max.</div>

    <div class="container">
        <div class="carousel-wrapper" id="carousel-wrapper"></div>
        <input type="file" id="imageInput" accept="image/*" />
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadInput = document.getElementById('import');
            if (!uploadInput) return;

            uploadInput.addEventListener('change', async (e) => {
                const file = e.target.files[0];
                if (!file) return;

                const reader = new FileReader();
                reader.onload = async (evt) => {
                    const workbook = XLSX.read(new Uint8Array(evt.target.result), {
                        type: 'array'
                    });
                    const rows = XLSX.utils.sheet_to_json(workbook.Sheets[workbook.SheetNames[
                        0]], {
                        defval: ''
                    });
                    if (!rows.length) {
                        alert('File kosong / format salah!');
                        return;
                    }

                    const postUrl = '/manageCateringPackage'; // <— URL sudah benar
                    const csrf = document.querySelector('meta[name="csrf-token"]').content;

                    const requests = rows.map(row => {
                        const fd = new FormData();
                        fd.append('_token', csrf);
                        fd.append('name', row['name']);
                        fd.append('categoryId', row['categoryId']);
                        fd.append('vendorId', row['vendorId']);
                        fd.append('averageCalories', row['averageCalories']);
                        fd.append('breakfastPrice', row['breakfastPrice']);
                        fd.append('lunchPrice', row['lunchPrice']);
                        fd.append('dinnerPrice', row['dinnerPrice']);

                        return fetch(postUrl, {
                            method: 'POST',
                            body: fd,
                            headers: {
                                'Accept': 'application/json'
                            }
                        })
                    });

                    try {
                        const res = await Promise.allSettled(requests);
                        const ok = res.filter(x => x.status === 'fulfilled').length;
                        alert(`Import selesai! Berhasil: ${ok}, Gagal: ${res.length - ok}`);
                        location.reload();
                    } catch (err) {
                        console.error(err);
                        alert('Terjadi kesalahan saat import!');
                    }
                };
                reader.readAsArrayBuffer(file);
            });
        });

        function handleEditClick(btn) {
            const data = JSON.parse(btn.dataset.package);
            console.log('DATA PACKAGE:', data); // ← Tambahkan ini dulu
            openEditModal(data);
        }

        function openEditModal(data) {
            // Ganti judul
            document.getElementById('packageModalLabel').innerText = 'Edit Package';

            // Isi field
            document.getElementById('packageName').value = data.name;
            document.getElementById('category').value = data.categoryId;
            document.getElementById('breakfastPrice').value = (+data.breakfastPrice).toFixed(2);
            document.getElementById('lunchPrice').value = (+data.lunchPrice).toFixed(2);
            document.getElementById('dinnerPrice').value = (+data.dinnerPrice).toFixed(2);
            document.getElementById('averageCalories').value = data.averageCalories;

            // Reset & tandai cuisines
            const cuisineInputs = document.getElementById('cuisineInputs');
            cuisineInputs.innerHTML = '';
            document.querySelectorAll('#cuisine-buttons button').forEach(b => {
                b.classList.replace('btn-success', 'btn-outline-secondary');
            });
            data.cuisines.forEach(id => {
                const btn = document.querySelector(`#cuisine-buttons button[onclick*="${id}"]`);
                if (btn) {
                    btn.classList.replace('btn-outline-secondary', 'btn-success');
                }
                const hidden = document.createElement('input');
                hidden.type = 'hidden';
                hidden.name = 'cuisines[]';
                hidden.value = id;
                cuisineInputs.appendChild(hidden);
            });

            // Set tujuan & spoof method
            const form = document.getElementById('packageForm');
            form.action = `/packages/${data.id}`; // route update
            // hapus spoof lama (kalau ada)
            form.querySelectorAll('input[name="_method"]').forEach(el => el.remove());
            // tambahkan spoof PUT
            const m = document.createElement('input');
            m.type = 'hidden';
            m.name = '_method';
            m.value = 'PUT';
            form.appendChild(m);

            // Tampilkan modal
            new bootstrap.Modal(document.getElementById('packageModal')).show();
        }
    </script>



    <script>
        document.getElementById('excelUpload').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                const data = new Uint8Array(e.target.result);
                const workbook = XLSX.read(data, {
                    type: 'array'
                });
                const sheetName = workbook.SheetNames[0];
                const worksheet = workbook.Sheets[sheetName];
                const jsonData = XLSX.utils.sheet_to_json(worksheet);

                // Ambil baris pertama
                const firstRow = jsonData[0];

                // Masukkan ke form
                if (firstRow) {
                    document.getElementById('packageName').value = firstRow["name"];
                    document.getElementById('category').value = mapCategory(firstRow["category"]);
                    document.getElementById('breakfastPrice').value = firstRow["breakfast_price"];
                    document.getElementById('lunchPrice').value = firstRow["lunch_price"];
                    document.getElementById('dinnerPrice').value = firstRow["dinner_price"];
                    document.getElementById('averageCalories').value = firstRow["average_calory"];

                    // Handle cuisine (anggap kolom isinya dipisah koma)
                    const cuisineIds = mapCuisineNames(firstRow["cuisine_type"]);
                    cuisineIds.forEach(id => toggleCuisine(id));
                }
            };

            reader.readAsArrayBuffer(file);
        });

        function mapCategory(name) {
            const categoryMap = {
                "Vegetarian": 1,
                "Gluten-Free": 2,
                "Halal": 3,
                "Low Carb": 4,
                "Low Calorie": 5,
                "Organic": 6,
            };
            return categoryMap[name] || '';
        }

        function mapCuisineNames(cuisineStr) {
            const cuisineMap = {
                "Indonesian": 1,
                "Chinese": 2,
                "Japanese": 3,
                "Korean": 4,
                "Western": 5,
                "Fusion": 6
            };
            const names = cuisineStr.split(',').map(n => n.trim());
            return names.map(n => cuisineMap[n]).filter(Boolean);
        }

        function toggleCuisine(id, event = null) {
            const existingInput = document.getElementById(`cuisine-${id}`);
            if (!existingInput) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'cuisineIds[]';
                input.value = id;
                input.id = `cuisine-${id}`;
                document.getElementById('cuisineInputs').appendChild(input);
            }

            if (event) {
                event.target.classList.toggle('btn-outline-secondary');
                event.target.classList.toggle('btn-success');
            }
        }

        function deletePackage(id) {
            if (confirm('Are you sure you want to delete this package?')) {
                fetch(`/packages/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Package deleted!');
                            location.reload(); // atau hapus row secara dinamis tanpa reload
                        } else {
                            alert('Failed to delete package.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Error deleting package.');
                    });
            }
        }
    </script>

    <script>
        const selectedCuisineIds = new Set();

        function toggleCuisine(id, event) {
            const inputContainer = document.getElementById('cuisineInputs');
            const button = event.target;

            if (selectedCuisineIds.has(id)) {
                selectedCuisineIds.delete(id);
                document.getElementById('cuisine-input-' + id).remove();
                button.classList.remove('btn-success');
                button.classList.add('btn-outline-secondary');
            } else {
                selectedCuisineIds.add(id);
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'cuisine_types[]';
                input.value = id;
                input.id = 'cuisine-input-' + id;
                inputContainer.appendChild(input);

                button.classList.remove('btn-outline-secondary');
                button.classList.add('btn-success');
            }
        }


        function openAddModal() {
            document.getElementById('packageModalLabel').innerText = 'Add Package';
            document.getElementById('packageForm').reset();

            selectedCuisineIds.clear();
            document.getElementById('cuisineInputs').innerHTML = '';
            document.querySelectorAll('#cuisine-buttons button').forEach(btn => {
                btn.classList.remove('btn-success');
                btn.classList.add('btn-outline-secondary');
            });
        }

        Dropzone.autoDiscover = false;

        // Inisialisasi tanpa auto upload
        var menuDropzone = new Dropzone("#menuDropzone", {
            url: "#", // dummy
            autoProcessQueue: false,
            maxFiles: 1,
            paramName: "menuPDFPath",
            acceptedFiles: ".pdf",
            addRemoveLinks: true
        });

        var imageDropzone = new Dropzone("#imageDropzone", {
            url: "#", // dummy
            autoProcessQueue: false,
            maxFiles: 1,
            paramName: "imgPath",
            acceptedFiles: ".png,.jpg,.jpeg",
            maxFilesize: 10,
            addRemoveLinks: true,
            dictDefaultMessage: "Drop image here or click to upload"
        });

        // Handler tunggal untuk submit form
        document.querySelector("#packageForm").addEventListener("submit", function(e) {
            // e.preventDefault();
            e.stopPropagation();

            const form = document.getElementById("packageForm");
            const formData = new FormData(form);
            console.log(form);
            for (const [key, value] of formData.entries()) {
                console.log(`${key}: ${value}`);
            }

            // Tambahkan file dari kedua Dropzone (jika ada)
            if (menuDropzone.getAcceptedFiles().length > 0) {
                formData.append("menuPDFPath", menuDropzone.getAcceptedFiles()[0]);
            }
            if (imageDropzone.getAcceptedFiles().length > 0) {
                formData.append("imgPath", imageDropzone.getAcceptedFiles()[0]);
            }

            // Kirim 1x request ke Laravel controller
            fetch("{{ route('packages.store') }}", {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(res => {
                    if (!res.ok) throw new Error("Upload gagal");
                    return res.text(); // bisa juga .json() sesuai respons Laravel
                })
                .then(response => {
                    console.log("Berhasil upload:", response);
                    window.location.href = "{{ route('manageCateringPackage') }}";
                })
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
