document.addEventListener('DOMContentLoaded', () => {
    /* ------------ Logo preview (unchanged) ------------- */
    const fileInput  = document.getElementById('vendorLogoInput');
    const previewImg = document.getElementById('vendorLogoPreview');
    const uploadBtn  = document.getElementById('logoUploadBtn');

    if (uploadBtn && fileInput) {
        uploadBtn.addEventListener('click', e => {
            e.preventDefault();
            fileInput.click();
        });
    }
    if (fileInput && previewImg) {
        fileInput.addEventListener('change', e => {
            const file = e.target.files?.[0];
            if (!file) return;
            const reader = new FileReader();
            reader.onload = ev => (previewImg.src = ev.target.result);
            reader.readAsDataURL(file);
        });
    }

    /* ------------ Cascading selects ------------- */
    const API_KEY = '543d80b3b490190006f5a670ce47292b0ebe9a3da6a097a0efc32b87096de8e4';

    const provSel = document.getElementById('provinsi');
    const kotaSel = document.getElementById('kota');
    const kecSel  = document.getElementById('kecamatan');
    const kelSel  = document.getElementById('kelurahan');

    async function fetchData(url) {
        const res = await fetch(url);
        if (!res.ok) throw new Error('Network error');
        const json = await res.json();
        return json.value || [];
    }

    function resetSelect(sel, placeholder) {
        sel.innerHTML = `<option value="">${placeholder}</option>`;
    }

    /* ---- 1. Load provinces on page load ---- */
    (async () => {
        resetSelect(provSel, 'Provinsi');
        const provs = await fetchData(`https://api.binderbyte.com/wilayah/provinsi?api_key=${API_KEY}`);
        provs.forEach(p => provSel.insertAdjacentHTML('beforeend',
            `<option value="${p.id}">${p.name}</option>`));
    })().catch(console.error);

    /* ---- 2. Province → cities ---- */
    provSel.addEventListener('change', async () => {
        resetSelect(kotaSel, 'Kota/Kabupaten');
        resetSelect(kecSel, 'Kecamatan');
        resetSelect(kelSel, 'Kelurahan');

        if (!provSel.value) return;
        try {
            const cities = await fetchData(`https://api.binderbyte.com/wilayah/kabupaten?api_key=${API_KEY}&id_provinsi=${provSel.value}`);
            cities.forEach(c => kotaSel.insertAdjacentHTML('beforeend',
                `<option value="${c.id}">${c.name}</option>`));
        } catch (err) { console.error(err); }
    });

    /* ---- 3. City → districts ---- */
    kotaSel.addEventListener('change', async () => {
        resetSelect(kecSel, 'Kecamatan');
        resetSelect(kelSel, 'Kelurahan');

        if (!kotaSel.value) return;
        try {
            const dists = await fetchData(`https://api.binderbyte.com/wilayah/kecamatan?api_key=${API_KEY}&id_kabupaten=${kotaSel.value}`);
            dists.forEach(d => kecSel.insertAdjacentHTML('beforeend',
                `<option value="${d.id}">${d.name}</option>`));
        } catch (err) { console.error(err); }
    });

    /* ---- 4. District → villages ---- */
    kecSel.addEventListener('change', async () => {
        resetSelect(kelSel, 'Kelurahan');
        if (!kecSel.value) return;
        try {
            const vills = await fetchData(`https://api.binderbyte.com/wilayah/kelurahan?api_key=${API_KEY}&id_kecamatan=${kecSel.value}`);
            vills.forEach(v => kelSel.insertAdjacentHTML('beforeend',
                `<option value="${v.id}">${v.name}</option>`));
        } catch (err) { console.error(err); }
    });

    // VALIDATION
    const form = document.querySelector('form');

    form.addEventListener('submit', function(e){
        let hasError = false;

        // clear prev error
        document.querySelectorAll('.text-danger').forEach(el => el.innerText = '');
        const name = document.getElementById('vendorName').value.trim();
        const logo = document.getElementById('vendorLogoInput').files[0];

        if(!logo){
            document.getElementById('error-logo').innerText = 'Vendor logo is required.'
            hasError = true;
        } else{
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
            if(!validTypes.includes(logo.type)){
                document.getElementById('error-logo').innerText = 'Only JPG, JPEG, or PNG files are allowed.';
                hasError = true;
            }
        }

        if(!name){
            document.getElementById('error-name').innerText = 'Vendor name is required.';
            hasError = true;
        }

        const breakfastStart = document.getElementById('fromBreakfast').value;
        const breakfastEnd = document.getElementById('untilBreakfast').value;
        const lunchStart = document.getElementById('fromLunch').value;
        const lunchEnd = document.getElementById('untilLunch').value;
        const dinnerStart = document.getElementById('fromDinner').value;
        const dinnerEnd = document.getElementById('untilDinner').value;

        function validateTime(start, end, startId, endId){
            if(start && end && start >= end){
                document.getElementById(`error-${endId}`).innerText = 'End time must be after start.';
                hasError = true;
            }
        }

        validateTime(breakfastStart, breakfastEnd, 'startBreakfast', 'closeBreakfast');
        validateTime(lunchStart, lunchEnd, 'startLunch', 'closeLunch');
        validateTime(dinnerStart, dinnerEnd, 'startDinner', 'closeDinner');
        

        const province = document.getElementById('provinsi');
        const city = document.getElementById('kota');
        const district = document.getElementById('kecamatan');
        const village = document.getElementById('kelurahan');

        function validateSelect(selectEl, errorId, fieldName){
            if(!selectEl.value || selectEl.selectedIndex === 0){
                document.getElementById(errorId).innerText = `${fieldName} is required.`;
                hasError = true;
            }
        }
        validateSelect(province, 'error-provinsi', 'Province');
        validateSelect(city, 'error-kota', 'City');
        validateSelect(district, 'error-kecamatan', 'District');
        validateSelect(village, 'error-kelurahan', 'Village');

        [province, city, district, village].forEach(select => {
            select.addEventListener('change', ()=> {
                const err = document.getElementById(`error-${select.id}`);
                if (err) err.innerText = '';
            })
        })

        const zipCode = document.getElementById('zipCode').value;
        const phoneNumber = document.getElementById('phoneNumber').value;
        const address = document.getElementById('address').value;
        if(!zipCode){
            document.getElementById('error-zipCode').innerText = 'Zip Code is required.';
            hasError = true;
        } else if(!/^\d{5}$/.test(zipCode)){
            document.getElementById('error-zipCode').innerText = 'Zip code must be 5 digits.'
            hasError = true;
        }

        if(!phoneNumber){
            document.getElementById('error-phoneNumber').innerText = 'Phone number is required.';
            hasError = true;
        }
        else if(!phoneNumber.startsWith('08')){
            document.getElementById('error-phoneNumber').innerText = 'Phone number must start with "08".';
            hasError = true;
        }
        else if(phoneNumber.length < 11 || phoneNumber.length >14){
            document.getElementById('error-phoneNumber').innerText = 'Phone number length must be between 11 and 14 digits.';
            hasError = true;
        }

        if(!address){
            document.getElementById('error-jalan').innerText = 'Address is required.'
            hasError = true;
        }

        if(hasError){
            e.preventDefault();
        }
    });


});
