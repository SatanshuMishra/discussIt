window.addEventListener("DOMContentLoaded", (event) => {
  $("#show-password").click(() => {
    showPassword();
  });
  function showPassword() {
    console.log("Show password");
    var x = document.getElementById("password");
    if (x.type === "password") {
      x.type = "text";
    } else {
      x.type = "password";
    }
  }
});
