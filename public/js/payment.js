
document.addEventListener('DOMContentLoaded', function () {
    // Get DOM elements
    const qrisRadio = document.getElementById('qris');
    const mainPayButton = document.getElementById('mainPayButton'); // Now this ID exists on the button
    const qrisPopup = document.getElementById('qrisPopup');
    const doneBtn = document.getElementById('doneBtn');
    const downloadQrisBtn = document.getElementById('downloadQrisBtn');
    const qrCodeImage = document.getElementById('qrCodeImage'); 
    const countdownTimerElement = document.getElementById('countdownTimer');
    const customMessageBox = document.getElementById('customMessageBox');
    const messageBoxText = document.getElementById('messageBoxText');
    const messageBoxOkBtn = document.getElementById('messageBoxOkBtn');

    let timerInterval;
    let timeLeft = 59; // Initial time for countdown

    function showMessage(message) {
        if (messageBoxText && customMessageBox) {
            messageBoxText.textContent = message;
            customMessageBox.classList.add('active');
        } else {
            console.error("Message box elements not found. Defaulting to alert.");
            alert(message); // Fallback
        }
    }

    if (messageBoxOkBtn && customMessageBox) {
        messageBoxOkBtn.addEventListener('click', () => {
        customMessageBox.classList.remove('active');
        });
    }

    function startTimer() {
        clearInterval(timerInterval); 
        timeLeft = 59; 
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
                } else {
                    let minutes = Math.floor(timeLeft / 60);
                    let seconds = timeLeft % 60;
                    countdownTimerElement.textContent = `${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
                }
            }
        }, 1000);
    }

    function showQrisPopup() {
        if (qrisPopup) {
            if(qrCodeImage) {
                qrCodeImage.src= 'asset/payment/qris.jpg'; // Set the QR code image source
            }
            qrisPopup.classList.add('active');
            startTimer(); 
        }
    }

    function hideQrisPopup() {
        if (qrisPopup) {
            qrisPopup.classList.remove('active');
            clearInterval(timerInterval); 
        }
    }

    if (mainPayButton) {
        mainPayButton.addEventListener('click', () => {
            const selectedMethod = document.querySelector('input[name="payment-button"]:checked');
            if (selectedMethod) {
                if (selectedMethod.id === 'qris') {
                    showQrisPopup();
                }
                else if (selectedMethod.id === 'wellpay'){
                    showConfirmPopup();
                }
                else {
                    showMessage(`Processing payment with ${selectedMethod.labels[0].textContent}...`);
                }
            } else {
                showMessage("Please select a payment method first.");
            }
        });
    }

    if (doneBtn) {
        doneBtn.addEventListener('click', () => {
            hideQrisPopup();
            showSuccessPopup();
            if (qrisRadio) qrisRadio.checked = false; 
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

    if (qrisPopup) {
        qrisPopup.addEventListener('click', function(event) {
            if (event.target === qrisPopup) { 
                hideQrisPopup();
                if (qrisRadio) qrisRadio.checked = false; 
          }
        });
    }

    const confirmPopup = document.getElementById('confirmationPopup');
    function showConfirmPopup() {
        if (confirmPopup) {
            confirmPopup.classList.add('active');
        }
    }  

    function hideConfirmPopup() {
        if (confirmPopup) {
            confirmPopup.classList.remove('active');
        }
    }

    const confirmBtn = document.getElementById('confirmBtn');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            hideConfirmPopup();
            showSuccessPopup();
        });
    }  

    function showSuccessPopup() {
        const successPopup = document.getElementById('successPopup');
        if (successPopup) {
            successPopup.classList.add('active');
        }
    }

    const backHomeBtn = document.getElementById('backHomeBtn');
    if (backHomeBtn) {
        backHomeBtn.addEventListener('click', function() {
            window.location.href = '/'; // Change to your homepage route if needed
        });
    }  
});
