(() => {
  const forms = document.querySelectorAll('.needs-validation')

  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault()
        event.stopPropagation()
      }

      form.classList.add('was-validated')
    }, false)
  })
})();

var loginCard = document.getElementById("login-card");
var cresgisterCard = document.getElementById("cregister-card");
function loginCregister() {
  loginCard.classList.toggle("d-none");
  cresgisterCard.classList.toggle("d-none");
} 
