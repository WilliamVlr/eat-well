
// document.addEventListener('DOMContentLoaded', function () {
//     // Get DOM elements
//     const qrisRadio = document.getElementById('qris');
//     const mainPayButton = document.getElementById('mainPayButton'); // Now this ID exists on the button
//     const qrisPopup = document.getElementById('qrisPopup');
//     const doneBtn = document.getElementById('doneBtn');
//     const downloadQrisBtn = document.getElementById('downloadQrisBtn');
//     const qrCodeImage = document.getElementById('qrCodeImage'); 
//     const countdownTimerElement = document.getElementById('countdownTimer');
//     const customMessageBox = document.getElementById('customMessageBox');
//     const messageBoxText = document.getElementById('messageBoxText');
//     const messageBoxOkBtn = document.getElementById('messageBoxOkBtn');

//     let timerInterval;
//     let timeLeft = 59; // Initial time for countdown

//     function showMessage(message) {
//         if (messageBoxText && customMessageBox) {
//             messageBoxText.textContent = message;
//             customMessageBox.classList.add('active');
//         } else {
//             console.error("Message box elements not found. Defaulting to alert.");
//             alert(message); // Fallback
//         }
//     }

//     if (messageBoxOkBtn && customMessageBox) {
//         messageBoxOkBtn.addEventListener('click', () => {
//         customMessageBox.classList.remove('active');
//         });
//     }

//     function startTimer() {
//         clearInterval(timerInterval); 
//         timeLeft = 59; 
//         if (countdownTimerElement) {
//             let minutes = Math.floor(timeLeft / 60);
//             let seconds = timeLeft % 60;
//             countdownTimerElement.textContent = `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
//         }
//         timerInterval = setInterval(() => {
//             timeLeft--;
//             if (countdownTimerElement) {
//                 if (timeLeft < 0) {
//                     clearInterval(timerInterval);
//                     countdownTimerElement.textContent = "Expired";
//                 } else {
//                     let minutes = Math.floor(timeLeft / 60);
//                     let seconds = timeLeft % 60;
//                     countdownTimerElement.textContent = `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
//                 }
//             }
//         }, 1000);
//     }

//     function showQrisPopup() {
//         if (qrisPopup) {
//             if(qrCodeImage) {
//                 qrCodeImage.src= 'asset/payment/qris.jpg'; // Set the QR code image source
//             }
//             qrisPopup.classList.add('active');
//             startTimer(); 
//         }
//     }

//     function hideQrisPopup() {
//         if (qrisPopup) {
//             qrisPopup.classList.remove('active');
//             clearInterval(timerInterval); 
//         }
//     }

//     // Wellpay Popup
//     const wellpayConfirmPopup = document.getElementById('wellpayConfirmPopup');
//     const wellpayBalanceText = document.getElementById('wellpayBalanceText');
//     const wellpayConfirmBtn = document.getElementById('wellpayConfirmBtn');
//     const wellpayCancelBtn = document.getElementById('wellpayCancelBtn');

//     // Fungsi untuk menampilkan popup Wellpay
//     function showWellpayConfirmPopup(balance) {
//         if (wellpayConfirmPopup && wellpayBalanceText) {
//             wellpayBalanceText.textContent = `Your current Wellpay balance is: Rp ${balance.toLocaleString('id-ID')},-`; // Menggunakan 'balance' langsung
//             wellpayConfirmPopup.classList.add('active');
//         }
//     }

//     // if (mainPayButton) {
//     //     mainPayButton.addEventListener('click', () => {
//     //         const selectedMethod = document.querySelector('input[name="payment-button"]:checked');
//     //         if (selectedMethod) {
//     //             if (selectedMethod.id === 'qris') {
//     //                 showQrisPopup();
//     //             }
//     //             else if (selectedMethod.id === 'wellpay'){
//     //                 showConfirmPopup();
//     //             }
//     //             else {
//     //                 showMessage(`Processing payment with ${selectedMethod.labels[0].textContent}...`);
//     //             }
//     //         } else {
//     //             showMessage("Please select a payment method first.");
//     //         }
//     //     });
//     // }

//     if (mainPayButton) {
//         mainPayButton.addEventListener('click', () => {
//             const selectedMethod = document.querySelector('input[name="payment-button"]:checked');
//             if (!selectedMethod) {
//                 showMessage("Please select a payment method first.");
//                 return;
//             }

//             const methodId = selectedMethod.value;

//             const WELLPAY_METHOD_ID = '1'; // Konfirmasi ID Wellpay adalah 1

//             if (methodId === WELLPAY_METHOD_ID) {
//                 $.ajax({
//                     url: '{{ route("user.wellpay.balance") }}',
//                     method: 'GET',
//                     success: function(response) {
//                         // Periksa response.wellpay
//                         if (response.wellpay !== undefined) {
//                             showWellpayConfirmPopup(response.wellpay); // Menggunakan response.wellpay
//                         } else {
//                             showMessage("Could not retrieve Wellpay balance. Please try again.");
//                         }
//                     },
//                     error: function(xhr, status, error) {
//                         console.error('Failed to fetch Wellpay balance:', error);
//                         showMessage("Failed to retrieve Wellpay balance. Please try again.");
//                     }
//                 });
//             } else if (selectedMethod.id === 'qris') {
//                 showQrisPopup();
//             } else {
//                 showGeneralConfirmPopup();
//             }
//         });
//     }

//     function processPaymentAjax() {
//         const selectedMethod = document.querySelector('input[name="payment-button"]:checked');
//         if (!selectedMethod) {
//             showMessage("No payment method selected for processing.");
//             return;
//         }

//         const methodId = selectedMethod.value;
//         const vendorId = $('#hiddenVendorId').val();
//         const startDate = $('#hiddenStartDate').val();
//         const endDate = $('#hiddenEndDate').val();

//         $.ajax({
//             url: '{{ route("checkout.process") }}',
//             method: 'POST',
//             data: {
//                 payment_method_id: methodId,
//                 vendor_id: vendorId,
//                 start_date: startDate,
//                 end_date: endDate,
//             },
//             success: function(response) {
//                 console.log('Checkout Response:', response);
//                 if (response.message === 'Checkout successful!') {
//                     showSuccessPopup();
//                 } else {
//                     showMessage(response.message || 'An error occurred during checkout.');
//                 }
//             },
//             error: function(xhr, status, error) {
//                 console.error('Checkout failed:', error);
//                 const errorMessage = xhr.responseJSON?.message || xhr.responseText || 'Checkout failed. Please try again.';
//                 showMessage(errorMessage);
//             }
//         });
//     }

//     if (doneBtn) {
//         doneBtn.addEventListener('click', () => {
//             hideQrisPopup();
//             showSuccessPopup();
//             if (qrisRadio) qrisRadio.checked = false; 
//         });
//     }

//     if (downloadQrisBtn && qrCodeImage) {
//         downloadQrisBtn.addEventListener('click', () => {
//             const link = document.createElement('a');
//             link.href = qrCodeImage.src; 
//             link.download = 'QRIS_Payment_Code.jpg';
//             document.body.appendChild(link);
//             link.click();
//             document.body.removeChild(link);
//         });
//     }

//     if (qrisPopup) {
//         qrisPopup.addEventListener('click', function(event) {
//             if (event.target === qrisPopup) { 
//                 hideQrisPopup();
//                 if (qrisRadio) qrisRadio.checked = false; 
//           }
//         });
//     }

//     const confirmPopup = document.getElementById('confirmationPopup');
//     function showConfirmPopup() {
//         if (confirmPopup) {
//             confirmPopup.classList.add('active');
//         }
//     }  

//     function hideConfirmPopup() {
//         if (confirmPopup) {
//             confirmPopup.classList.remove('active');
//         }
//     }

//     const confirmBtn = document.getElementById('confirmBtn');
//     if (confirmBtn) {
//         confirmBtn.addEventListener('click', function() {
//             hideConfirmPopup();
//             showSuccessPopup();
//         });
//     }  

//     function showSuccessPopup() {
//         const successPopup = document.getElementById('successPopup');
//         if (successPopup) {
//             successPopup.classList.add('active');
//         }
//     }

//     const backHomeBtn = document.getElementById('backHomeBtn');
//     if (backHomeBtn) {
//         backHomeBtn.addEventListener('click', function() {
//             window.location.href = '/home'; // Change to your homepage route if needed
//         });
//     }  
// });


// resources/js/payment.js

document.addEventListener('DOMContentLoaded', function () {
    // --- Get DOM Elements ---
    const qrisRadio = document.getElementById('qris');
    const wellpayRadio = document.getElementById('wellpay'); // Added for completeness, though not explicitly used for direct click handling
    const mainPayButton = document.getElementById('mainPayButton');

    // Popups elements
    const qrisPopup = document.getElementById('qrisPopup');
    const wellpayConfirmPopup = document.getElementById('wellpayConfirmPopup');
    const confirmationPopup = document.getElementById('confirmationPopup'); // General confirmation popup
    const successPopup = document.getElementById('successPopup');
    const customMessageBox = document.getElementById('customMessageBox');

    // Elements inside popups
    const doneBtn = document.getElementById('doneBtn');
    const downloadQrisBtn = document.getElementById('downloadQrisBtn');
    const qrCodeImage = document.getElementById('qrCodeImage');
    const countdownTimerElement = document.getElementById('countdownTimer');
    const messageBoxText = document.getElementById('messageBoxText');
    const messageBoxOkBtn = document.getElementById('messageBoxOkBtn');
    const wellpayBalanceText = document.getElementById('wellpayBalanceText');
    const wellpayConfirmBtn = document.getElementById('wellpayConfirmBtn');
    const wellpayCancelBtn = document.getElementById('wellpayCancelBtn');
    const confirmBtn = document.getElementById('confirmBtn'); // Button inside general confirmation popup
    const backHomeBtn = document.getElementById('backHomeBtn');

    let timerInterval;
    let timeLeft = 59; // Initial time for QRIS countdown

    // --- Helper Functions for Popups and Messages ---

    /** Displays a custom message box. */
    function showMessage(message) {
        if (messageBoxText && customMessageBox) {
            messageBoxText.textContent = message;
            customMessageBox.classList.add('active');
        } else {
            console.error("Message box elements not found. Defaulting to alert.");
            alert(message); // Fallback if elements are missing
        }
    }

    /** Hides the custom message box. */
    function hideMessageBox() {
        if (customMessageBox) {
            customMessageBox.classList.remove('active');
        }
    }

    /** Starts the QRIS countdown timer. */
    function startTimer() {
        clearInterval(timerInterval); // Clear any existing timer
        timeLeft = 59; // Reset time
        if (countdownTimerElement) {
            let minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;
            countdownTimerElement.textContent = `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        }
        timerInterval = setInterval(() => {
            timeLeft--;
            if (countdownTimerElement) {
                if (timeLeft < 0) {
                    clearInterval(timerInterval);
                    countdownTimerElement.textContent = "Expired";
                    // Optionally: disable download button or show "expired" state
                } else {
                    let minutes = Math.floor(timeLeft / 60);
                    let seconds = timeLeft % 60;
                    countdownTimerElement.textContent = `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                }
            }
        }, 1000);
    }

    /** Shows the QRIS payment popup. */
    function showQrisPopup() {
        if (qrisPopup) {
            // Set the QR code image source (replace with dynamic QR generation if needed)
            if (qrCodeImage) {
                qrCodeImage.src = '/asset/payment/qris.jpg'; // Adjust path if necessary
            }
            qrisPopup.classList.add('active');
            startTimer(); // Start countdown when QRIS popup is shown
        }
    }

    /** Hides the QRIS payment popup. */
    function hideQrisPopup() {
        if (qrisPopup) {
            qrisPopup.classList.remove('active');
            clearInterval(timerInterval); // Stop timer when popup is hidden
        }
    }

    /** Shows the Wellpay confirmation popup. */
    function showWellpayConfirmPopup(balance) {
        if (wellpayConfirmPopup && wellpayBalanceText) {
            // wellpayBalanceText.textContent = `Your current Wellpay balance is: Rp ${balance.toLocaleString('id-ID')}`;
            wellpayBalanceText.textContent = `Your current Wellpay balance is: Rp ${balance.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            // wellpayBalanceText.textContent = `Your current Wellpay balance is: Rp ${balance.toLocaleString('id-ID', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            wellpayConfirmPopup.classList.add('active');
        }
    }

    /** Hides the Wellpay confirmation popup. */
    function hideWellpayConfirmPopup() {
        if (wellpayConfirmPopup) {
            wellpayConfirmPopup.classList.remove('active');
        }
    }

    /** Shows the general confirmation popup. */
    function showGeneralConfirmPopup() {
        if (confirmationPopup) {
            confirmationPopup.classList.add('active');
        }
    }

    /** Hides the general confirmation popup. */
    function hideGeneralConfirmPopup() {
        if (confirmationPopup) {
            confirmationPopup.classList.remove('active');
        }
    }

    /** Shows the success popup. */
    function showSuccessPopup() {
        if (successPopup) {
            successPopup.classList.add('active');
        }
    }

    // --- Centralized AJAX Function for Payment Processing ---

    /**
     * Handles the AJAX call to the backend for payment processing.
     * This function is called after relevant popups are confirmed.
     */
    function processPaymentAjax() {
        const selectedMethod = document.querySelector('input[name="payment-button"]:checked');
        if (!selectedMethod) {
            showMessage("No payment method selected for processing.");
            return;
        }

        const methodId = selectedMethod.value; // e.g., '1' for Wellpay, '2' for QRIS
        const vendorId = document.getElementById('hiddenVendorId')?.value; // Using optional chaining for safety
        const startDate = document.getElementById('hiddenStartDate')?.value;
        const endDate = document.getElementById('hiddenEndDate')?.value;
        const totalOrderPrice = document.getElementById('hiddenCartTotalPrice')?.value; // For debugging, not sent to backend

        // Basic validation for data
        if (!vendorId || !startDate || !endDate) {
            showMessage("Missing essential order details. Please refresh the page.");
            console.error("Missing essential order details for AJAX:", {vendorId, startDate, endDate});
            return;
        }

        // --- AJAX Call to Backend ---
        const checkoutUrl = window.App.routes.checkoutProcess;
        $.ajax({
            url: checkoutUrl,
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token
                payment_method_id: methodId,
                vendor_id: vendorId,
                start_date: startDate,
                end_date: endDate,
                // Add other form data like notes, delivery address if you have them
            },
            success: function(response) {
                console.log('Checkout Response:', response);
                if (response.message === 'Checkout successful!') {
                    showSuccessPopup();
                    // Optionally, redirect to order history or print receipt
                } else {
                    // Display error message from backend
                    showMessage(response.message || 'An unknown error occurred during checkout.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Checkout failed:', error);
                const errorMessage = xhr.responseJSON?.message || xhr.responseText || 'Checkout failed. Please try again.';
                showMessage(errorMessage);
            }
        });
    }

    // --- Event Listeners ---

    // Message Box OK button
    if (messageBoxOkBtn) {
        messageBoxOkBtn.addEventListener('click', hideMessageBox);
    }

    // Main Pay Button
    if (mainPayButton) {
        mainPayButton.addEventListener('click', () => {
            const selectedMethod = document.querySelector('input[name="payment-button"]:checked');
            if (!selectedMethod) {
                showMessage("Please select a payment method first.");
                return;
            }

            const methodId = selectedMethod.value; // Assumed to be the methodId from DB
            const WELLPAY_METHOD_ID = '1'; // Configured Wellpay method ID

            if (methodId === WELLPAY_METHOD_ID) {
                $.ajax({
                    url: window.App.routes.userWellpayBalance,
                    method: 'GET',
                    success: function(response) {
                        if (response.wellpay !== undefined) {
                            const wellpayBalanceAsNumber = parseFloat(response.wellpay); 
                            // showWellpayConfirmPopup(response.wellpay);
                            if (!isNaN(wellpayBalanceAsNumber)) {
                                showWellpayConfirmPopup(wellpayBalanceAsNumber); // Teruskan angka yang sudah dikonversi
                            } else {
                                console.error("Wellpay balance received from server is not a valid number:", response.wellpay);
                                showMessage("Wellpay balance format error. Please contact support.");
                            }
                        } else {
                            showMessage("Could not retrieve Wellpay balance. Please try again.");
                            console.error("Wellpay balance response format incorrect:", response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Failed to fetch Wellpay balance:', error, xhr);
                        showMessage("Failed to retrieve Wellpay balance. Please check your internet connection.");
                    }
                });
            } else if (selectedMethod.id === 'qris') {
                showQrisPopup();
            } else {
                showGeneralConfirmPopup();
            }
        });
    }

    // QRIS Popup buttons
    if (doneBtn) {
        doneBtn.addEventListener('click', () => {
            hideQrisPopup();
            // After QRIS done, process payment (this assumes user completed QRIS payment)
            // You might need a server-side check here for actual payment status
            processPaymentAjax();
            if (qrisRadio) qrisRadio.checked = false; // Uncheck QRIS radio button
        });
    }

    if (downloadQrisBtn && qrCodeImage) {
        downloadQrisBtn.addEventListener('click', () => {
            const link = document.createElement('a');
            link.href = qrCodeImage.src;
            link.download = 'QRIS_Payment_Code.jpg';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        });
    }

    // Close QRIS popup when clicking outside content
    if (qrisPopup) {
        qrisPopup.addEventListener('click', function(event) {
            if (event.target === qrisPopup) {
                hideQrisPopup();
                if (qrisRadio) qrisRadio.checked = false;
            }
        });
    }

    // Wellpay Confirmation Popup buttons
    if (wellpayConfirmBtn) {
        wellpayConfirmBtn.addEventListener('click', function() {
            hideWellpayConfirmPopup();
            processPaymentAjax(); // Process payment after Wellpay confirmation
        });
    }

    if (wellpayCancelBtn) {
        wellpayCancelBtn.addEventListener('click', function() {
            hideWellpayConfirmPopup();
            showMessage("Wellpay payment cancelled.");
            // Optionally uncheck radio button:
            if (wellpayRadio) wellpayRadio.checked = false;
        });
    }

    // General Confirmation Popup buttons
    if (confirmBtn) { // This is the "Confirm Payment" button inside the general popup
        confirmBtn.addEventListener('click', function() {
            hideGeneralConfirmPopup();
            processPaymentAjax(); // Process payment after general confirmation
        });
    }

    // Success Popup buttons
    if (backHomeBtn) {
        backHomeBtn.addEventListener('click', function() {
            window.location.href = '/home'; // Adjust to your actual homepage route
        });
    }
});