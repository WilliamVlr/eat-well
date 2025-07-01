document.addEventListener('DOMContentLoaded', function() {
    
    document.querySelectorAll('.menu-link').forEach(link => {
        link.addEventListener('click', function(e) {
            document.querySelectorAll('.menu-link').forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            // e.preventDefault(); // Uncomment if you don't want the link to navigate
        });
    });

    const input = document.getElementById('profilePicInput');
    const preview = document.getElementById('profilePicPreview');
    if (input && preview) {
        input.addEventListener('change', function(e) {
            if (e.target.files && e.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(ev) {
                    preview.src = ev.target.result;
                }
                reader.readAsDataURL(e.target.files[0]);
            }
        });
    }

     const editBtnGroup = document.querySelector('.edit-btn-group');
    const nameInput = document.getElementById('nameInput');
    const dobMonth = document.getElementById('dob_month');
    const dobDay = document.getElementById('dob_day');
    const dobYear = document.getElementById('dob_year');
    const genderRadios = document.querySelectorAll('.gender-radio');

    let originalProfile = {};

    function setProfileEditMode(on) {
        nameInput.readOnly = !on;
        dobMonth.disabled = !on;
        dobDay.disabled = !on;
        dobYear.disabled = !on;
        genderRadios.forEach(radio => radio.disabled = !on);

        if (on) {
            originalProfile = {
                name: nameInput.value,
                dobMonth: dobMonth.value,
                dobDay: dobDay.value,
                dobYear: dobYear.value,
                gender: Array.from(genderRadios).find(r => r.checked)?.value
            };
        }    
    }

    function attachEditBtnListener() {
        const editBtn = editBtnGroup.querySelector('.edit-data');
        if (editBtn) {
            editBtn.addEventListener('click', function() {
                setProfileEditMode(true);
                editBtnGroup.innerHTML = `
                    <button class="inter font-medium save-profile-btn">Save</button>
                    <button class="inter font-medium cancel-profile-btn">Cancel</button>
                `;
                // Save
                editBtnGroup.querySelector('.save-profile-btn').addEventListener('click', function() {
                    setProfileEditMode(false);
                    editBtnGroup.innerHTML = `<button class="inter font-medium edit-data">Edit</button>`;
                    attachEditBtnListener();
                });
                // Cancel
                editBtnGroup.querySelector('.cancel-profile-btn').addEventListener('click', function() {
                    nameInput.value = originalProfile.name;
                    dobMonth.value = originalProfile.dobMonth;
                    dobDay.value = originalProfile.dobDay; 
                    dobYear.value = originalProfile.dobYear;
                    genderRadios.forEach(radio => {
                        radio.checked = (radio.value === originalProfile.gender);
                    });
                    setProfileEditMode(false);
                    editBtnGroup.innerHTML = `<button class="inter font-medium edit-data">Edit</button>`;
                    attachEditBtnListener();
                });
            });
        }
    }
    setProfileEditMode(false);
    attachEditBtnListener();

    // --- Change Password Section ---
    const changeBtnGroup = document.querySelector('.change-btn-group');
    const oldPassword = document.getElementById('oldPassword');
    const newPassword = document.getElementById('newPassword');
    const verifyPassword = document.getElementById('verifyPassword');

    function setPasswordEditMode(on) {
        oldPassword.readOnly = !on;
        newPassword.readOnly = !on;
        verifyPassword.readOnly = !on;
    }

    function attachChangeBtnListener() {
        const changeBtn = changeBtnGroup.querySelector('.save-password-btn');
        if (changeBtn) {
            changeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                setPasswordEditMode(true);
                changeBtnGroup.innerHTML = `
                    <button class="inter save-password-btn">Save</button>
                    <button class="inter cancel-password-btn">Cancel</button>
                `;
                // Save
                changeBtnGroup.querySelector('.save-password-btn').addEventListener('click', function(e) {
                    e.preventDefault();
                    if (oldPassword.value === '' || newPassword.value === '' || verifyPassword.value === '') {
                        alert('Please fill all fields.');
                        return;
                    }
                    if (newPassword.value !== verifyPassword.value) {
                        alert('New password and verification do not match.');
                        return;
                    }
                    alert('Password changed successfully!');
                    oldPassword.value = '';
                    newPassword.value = '';
                    verifyPassword.value = '';
                    setPasswordEditMode(false);
                    changeBtnGroup.innerHTML = `<button class="save-password-btn">Change</button>`;
                    attachChangeBtnListener();
                });
                // Cancel
                changeBtnGroup.querySelector('.cancel-password-btn').addEventListener('click', function(e) {
                    e.preventDefault();
                    oldPassword.value = '';
                    newPassword.value = '';
                    verifyPassword.value = '';
                    setPasswordEditMode(false);
                    changeBtnGroup.innerHTML = `<button class="save-password-btn">Change</button>`;
                    attachChangeBtnListener();
                });
            });
        }
    }
    setPasswordEditMode(false);
    attachChangeBtnListener();

    // --- Password Visibility Toggle ---
    document.querySelectorAll('.toggle-password').forEach(function(toggle) {
        toggle.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('.material-symbols-outlined');
            if (input.type === 'password') {
                input.type = 'text';
                icon.textContent = 'visibility';
            } else {
                input.type = 'password';
                icon.textContent = 'visibility_off';
            }
        });
    });
});