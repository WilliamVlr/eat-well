{{-- resources/views/manageOrder.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manage Orders</title>

    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <style>
        /* ----------- WARNA & KOMPOSISI DASAR ----------- */
        body {
            background: #0b3d2e;
            color: #fff;
            margin-top: 80px
        }

        h1 {
            font-weight: 700
        }

        .tab-btn {
            color: #fff;
            border-color: #fff
        }

        .tab-btn.active {
            background: #fff;
            color: #14532d;
            font-weight: 700
        }

        /* ----------- KARTU & SLOT MAKANAN ----------- */
        .card {
            background: #fff;
            color: #000;
            border-radius: .75rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .1);
            height: 100%;
            display: flex;
            flex-direction: column
        }

        .card-body {
            flex: 1;
            display: flex;
            flex-direction: column
        }

        .order-header {
            display: flex;
            justify-content: flex-end;
            font-weight: 600;
            font-size: .95rem;
            margin-bottom: .5rem;
            color: #14532d
        }

        .meal-box {
            border-radius: .5rem;
            padding: .8rem 1rem;
            margin-bottom: 1rem;
            background: #ebf5ee;
            color: #14532d
        }

        .meal-box-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: 700;
            font-size: 1.1rem;
            margin-bottom: .5rem
        }

        .meal-entry {
            font-weight: 600;
            font-size: .95rem;
            margin-bottom: .3rem
        }

        .meal-select {
            width: 140px;
            height: 32px;
            padding: 4px 12px;
            font-size: .9rem;
            font-weight: 700;
            border-radius: .5rem;
            border: 1.5px solid transparent;
            cursor: pointer;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .1);
            appearance: none;
            text-align-last: center;
            transition: .3s
        }

        .meal-select.preparing {
            background: #fff7e6;
            color: #8a6d0b;
            border-color: #f9d71c;
            box-shadow: 0 0 6px #f9d71c88
        }

        .meal-select.delivering {
            background: #dbefff;
            color: #0b3d91;
            border-color: #4a90e2;
            box-shadow: 0 0 6px #4a90e288
        }

        .meal-select.received {
            background: #d9f7e4;
            color: #1f6f3a;
            border-color: #44bb44;
            box-shadow: 0 0 6px #44bb4488
        }
    </style>
</head>

<body class="p-4">

    {{-- ---------- HEADER (search & filter) ---------- --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h1 class="mb-3 mb-md-0">Manage Orders</h1>
        <div class="d-flex gap-2">
            <input id="search-input" type="text" class="form-control form-control-sm"
                placeholder="Search by Order #" />
            <select id="package-filter" class="form-select form-select-sm">
                <option value="all">All Packages</option>
                @foreach ($packages as $pkg)
                    <option value="{{ $pkg }}">{{ $pkg }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- ---------- TAB sebagai LINK ---------- --}}
    <div class="mb-4">
        <a href="{{ route('vendor.orders', ['week' => 'current']) }}"
            class="btn tab-btn {{ request('week', 'current') === 'current' ? 'active' : '' }} me-2">
            This Week
        </a>

        <a href="{{ route('vendor.orders', ['week' => 'next']) }}"
            class="btn tab-btn {{ request('week') === 'next' ? 'active' : '' }}">
            Next Week
        </a>
    </div>

    <p id="empty-msg" class="text-center fw-bold py-5" style="display:none;">No Orders Yet</p>

    <div class="row g-4" id="order-container"></div>

    {{-- ---------- SCRIPT ---------- --}}
    <script>
        const orders = @json($orders); // sudah di‑filter oleh controller
        const isNextWeek = {{ request('week') === 'next' ? 'true' : 'false' }}; // <<< NEW
        const mealTypes = [{
                key: 'Morning',
                label: 'Breakfast'
            },
            {
                key: 'Afternoon',
                label: 'Lunch'
            },
            {
                key: 'Evening',
                label: 'Dinner'
            }
        ];
        const statusClassMap = {
            Prepared: 'preparing',
            Delivered: 'delivering',
            Arrived: 'received'
        };

        const orderContainer = document.getElementById('order-container');
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const searchInput = document.getElementById('search-input');
        const emptyMsg = document.getElementById('empty-msg');
        const packageFilter = document.getElementById('package-filter');

        /* --------- SIMPAN PERUBAHAN STATUS (untuk This Week) --------- */
        function updateMealStatus(select, orderId, slot) {
            const status = select.value;
            select.classList.remove('preparing', 'delivering', 'received');
            select.classList.add(statusClassMap[status]);

            fetch(`/delivery-status/${orderId}/${slot}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf
                    },
                    body: JSON.stringify({
                        status
                    })
                })
                .then(r => r.ok ? r.json() : Promise.reject(r))
                .then(res => {
                    if (!res.success) throw 'fail';
                    location.reload();
                })
                .catch(() => alert('Save failed'));
        }

        /* --------- POP‑UP CANCEL --------- */
        function attachCancelHandlers() { // <<< NEW
            document.querySelectorAll('.btn-cancel').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Pesanan akan dibatalkan dan tidak dapat dipulihkan.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, cancel it!',
                        cancelButtonText: 'No',
                        reverseButtons: true,

                        confirmButtonColor: '#28a745', // hijau Bootstrap (atau ganti hex lain)
                        cancelButtonColor: '#d33',
                    }).then(r => {
                        if (r.isConfirmed) {
                            fetch(`/orders/${id}/cancel`, {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': csrf,
                                        'Accept': 'application/json'
                                    }
                                })
                                .then(res => {
                                    if (res.ok) location.reload();
                                })
                                .catch(() => Swal.fire('Error', 'Network error', 'error'));
                        }
                    });
                });
            });
        }

        /* --------- RENDER KARTU --------- */
        function renderOrders() {
            const term = searchInput.value.trim().toLowerCase();
            const selectedPackage = packageFilter.value;

            orderContainer.innerHTML = '';
            let shown = 0;

            orders.forEach(order => {
                const orderIdStr = 'inv' + String(order.id).padStart(3, '0');
                if (term && !orderIdStr.includes(term)) return;

                if (selectedPackage !== 'all') {
                    const ok = order.order_items.some(i => i.package.name === selectedPackage);
                    if (!ok) return;
                }

                shown++;
                const deliveryMap = {};
                order.delivery_statuses.forEach(ds => {
                    deliveryMap[ds.slot.toLowerCase()] = ds.status;
                });

                let mealSections = '';
                if (!isNextWeek) { // <<< NEW (status hanya minggu ini)
                    mealTypes.forEach(meal => {
                        const items = order.order_items.filter(i => i.package_time_slot === meal.key);
                        const filtered = selectedPackage === 'all' ?
                            items :
                            items.filter(i => i.package.name === selectedPackage);
                        if (!filtered.length) return;

                        const entries = filtered.map(i =>
                            `<div class="meal-entry">${i.package.name} (${i.quantity}x)</div>`
                        ).join('');

                        const status = deliveryMap[meal.key.toLowerCase()] || 'Prepared';

                        mealSections += `
            <div class="meal-box">
              <div class="meal-box-header">
                <span>${meal.label}</span>
                <select class="form-select form-select-sm meal-select ${statusClassMap[status]}"
                        onchange="updateMealStatus(this, ${order.id}, '${meal.key}')">
                  <option value="Prepared"  ${status==='Prepared'?'selected':''}>Prepared</option>
                  <option value="Delivered" ${status==='Delivered'?'selected':''}>Delivered</option>
                  <option value="Arrived"   ${status==='Arrived'  ?'selected':''}>Arrived</option>
                </select>
              </div>
              <div class="meal-entries">${entries}</div>
            </div>`;
                    });
                } else { // <<< NEW — tetap tampil list paket tanpa dropdown
                    order.order_items.forEach(it => {
                        if (selectedPackage !== 'all' && it.package.name !== selectedPackage) return;
                        mealSections += `
            <div class="meal-entry ms-1 mb-1">
              • ${it.package.name} (${it.quantity}x) — ${it.package_time_slot}
            </div>`;
                    });
                }

                /* tombol Cancel hanya jika Next Week */
                let cancelBtn = '';
                if (isNextWeek) {
                    cancelBtn = `
          <button class="btn btn-danger w-100 mt-3 btn-cancel"
                  data-id="${order.id}">
            Cancel Order
          </button>`;
                }

                orderContainer.innerHTML += `
        <div class="col-12 col-md-6 col-lg-4 d-flex">
          <div class="card w-100">
            <div class="card-body">
              <div class="order-header">Order #INV${String(order.id).padStart(3,'0')}</div>
              <p class="mb-1">${order.user?.name || '-'}</p>
              <p class="mb-1">${order.user?.phone || '-'}</p>
              <p class="mb-1">${order.user?.address || '-'}</p>
              <p class="mb-2 text-muted"><i>${order.user?.notes || '-'}</i></p>
              ${mealSections}
              ${cancelBtn}
            </div>
          </div>
        </div>`;
            });

            emptyMsg.style.display = shown === 0 ? 'block' : 'none';
            attachCancelHandlers(); // <<< NEW
        }

        searchInput.addEventListener('input', renderOrders);
        packageFilter.addEventListener('change', renderOrders);
        renderOrders();
    </script>

    {{-- SweetAlert & Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> {{-- <<< NEW --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
