document.addEventListener("DOMContentLoaded", function () {
  const password1 = document.getElementById("password1");
  const password2 = document.getElementById("password2");

  function validatePasswordsMatch() {
    if (password1.value !== password2.value) {
      password2.setCustomValidity("Hasła muszą być takie same!");
    } else {
      password2.setCustomValidity(""); 
    }
  }

  password1.addEventListener("input", validatePasswordsMatch);
  password2.addEventListener("input", validatePasswordsMatch);
});
