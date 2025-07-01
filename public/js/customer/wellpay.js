document.addEventListener('DOMContentLoaded', function() {
    const wellpayBalanceAmount = document.getElementById('wellpayBalanceAmount');
    const toggleVisibilityBtn = document.getElementById('toggleVisibilityBtn');
    const visibilityIcon = document.getElementById('visibilityIcon');

    // Simpan saldo asli saat halaman dimuat, diambil dari span
    const originalBalanceText = wellpayBalanceAmount.textContent;

    // Ekstrak bagian numerik dari saldo asli untuk menghitung panjang bullet
    const numericPart = originalBalanceText.replace(/[^0-9]/g, '');
    const numberOfBullets = numericPart.length;
    const bulletString = '•'.repeat(numberOfBullets);

    let isBalanceHidden = true; // Saldo tersembunyi secara default

    // Fungsi untuk menampilkan saldo
    function showBalance() {
        wellpayBalanceAmount.textContent = originalBalanceText;
        wellpayBalanceAmount.classList.remove('bullet-display'); // Hapus class styling bullet
        visibilityIcon.textContent = 'visibility_off';
        isBalanceHidden = false;
    }

    // Fungsi untuk menyembunyikan saldo dengan format bullet
    function hideBalance() {
        wellpayBalanceAmount.textContent = bulletString;
        wellpayBalanceAmount.classList.add('bullet-display'); // Tambahkan class styling bullet
        visibilityIcon.textContent = 'visibility';
        isBalanceHidden = true;
    }

    // Terapkan kondisi awal saat halaman dimuat
    if (isBalanceHidden) {
        hideBalance();
    } else {
        showBalance();
    }

    // Tambahkan event listener untuk tombol toggle
    toggleVisibilityBtn.addEventListener('click', function() {
        if (isBalanceHidden) {
            showBalance();
        } else {
            hideBalance();
        }
    });
});