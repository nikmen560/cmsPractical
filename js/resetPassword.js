document.getElementById("password").onchange = function() {

let newPassword = document.getElementById("password");
let newPasswordConfirm = document.getElementById("confirmPassword");
let submitPassword = document.getElementById("submitPassword");

if (newPasswordConfirm.value === "") {
  submitPassword.disabled = true;
}
newPasswordConfirm.addEventListener("keyup", (event) => {
  if (newPassword.value !== newPasswordConfirm.value) {
    event.target.style.borderRadius= '3px';
    event.target.style.borderColor= "red";
    submitPassword.disabled = true;
  } else {
    submitPassword.disabled = false;
    event.target.style.background = "none";
  }
});

}