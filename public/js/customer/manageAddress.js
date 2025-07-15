$(function() {
    const csrfToken = $('meta[name="csrf-token"]').attr('content');
    if (csrfToken) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        });
    } else {
        console.error('CSRF token not found! Please ensure <meta name="csrf-token" content="..."> is in your head.');
    }
});

// AJAX
$(document).ready(function() {
    const setDefaultAddressUrl = $('#set-default-address-url-form').attr('action');

    if (!setDefaultAddressUrl) {
        console.error("Set Default Address URL not found. Check '#set-default-address-url-form' action attribute in your Blade file.");
        return;
    }

    $(document).on('change', '.set-default-address', function() {
        const $this = $(this); // Cache jQuery object untuk efisiensi
        const addressId = $this.data('address-id');
        const isChecked = $this.is(':checked');

        // --- DEBUGGING CONSOLE LOGS ---
        // console.log('--- Debugging Toggle Change ---');
        // console.log('Element clicked:', $this[0]);
        // console.log('Raw data-address-id attribute:', $this.attr('data-address-id'));
        // console.log('Parsed addressId from .data():', addressId);
        // console.log('Toggle isChecked:', isChecked);
        // console.log('AJAX URL:', setDefaultAddressUrl);
        // console.log('-----------------------------');

        // Proses jika toggle diaktifkan (berarti pengguna ingin menjadikannya alamat utama)
        if (isChecked) {
            if (typeof addressId === 'undefined' || addressId === null || addressId === '') {
                $('#errorMessage').text('Error: ID alamat tidak ditemukan untuk operasi ini. Mohon refresh halaman atau hubungi dukungan.');
                $('#errorModal').modal('show');
                $this.prop('checked', false); // Kembalikan toggle ke status tidak aktif
                return;
            }

            $.ajax({
                url: setDefaultAddressUrl,
                method: 'POST',
                data: {
                    address_id: addressId
                },
                success: function(response) {
                    // Fungsi ini dijalankan jika permintaan AJAX berhasil dan server mengembalikan status 2xx
                    if (response.success) {
                        // update UI untuk menandai alamat baru sebagai utama

                        // 1. Reset semua badge "Main Address" menjadi abu-abu dan pastikan semua toggle switch lain tidak aktif.
                        //    Iterasi melalui setiap div alamat utama (dengan class 'main-address')
                        $('.main-address').each(function() {
                            $(this).find('.badge').css('background-color', '#909090');
                            $(this).find('.set-default-address').prop('checked', false);
                        });

                        // 2. Set badge dan toggle untuk alamat yang baru menjadi utama.
                        //    Temukan elemen div 'main-address' yang berisi toggle yang baru diaktifkan.
                        const $currentAddressDiv = $(`.set-default-address[data-address-id="${addressId}"]`).closest('.main-address');
                        $currentAddressDiv.find('.badge').css('background-color', '#D96323');
                        $currentAddressDiv.find('.set-default-address').prop('checked', true);

                        $('#successModal').modal('show');
                    } else {
                        alert('Gagal mengubah alamat utama: ' + (response.message || 'Terjadi kesalahan tidak dikenal.'));
                        $this.prop('checked', false);
                    }
                },
                error: function(xhr, status, error) {
                    // Fungsi ini dijalankan jika ada kesalahan AJAX (misalnya, status 4xx atau 5xx dari server)
                    let errorMessage = 'Terjadi kesalahan saat menghubungi server.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        // Coba ambil pesan error dari respons JSON jika ada (misalnya dari validasi Laravel)
                        errorMessage += ' ' + xhr.responseJSON.message;
                    } else if (error) {
                        // Pesan error dari objek error standar (misalnya "Not Found", "Internal Server Error")
                        errorMessage += ' ' + error;
                    } else {
                        // Jika tidak ada pesan spesifik, gunakan status HTTP
                        errorMessage += ' Status: ' + xhr.status + ' (' + xhr.statusText + ')';
                    }
                    alert(errorMessage);
                    // Selalu kembalikan toggle ke status tidak aktif jika terjadi error
                    $this.prop('checked', false);
                }
            });
        } else {
            // Logika jika toggle dimatikan (misalnya, pengguna mencoba menonaktifkan alamat utama -> gabisa kalo gapilih yg lain)
            $('#warningModal').modal('show');
            $this.prop('checked', true); // Pastikan toggle kembali ke kondisi 'checked' (karena tidak bisa dinonaktifkan)
        }
    });
});