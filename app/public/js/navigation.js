window.addEventListener("DOMContentLoaded", (event) => {
  let loginEl = document.querySelector(".log-in");
  let loggedinEl = document.querySelector(".logged-in");

  if (loginEl !== null) {
    loginEl.addEventListener("click", function () {
      openNavDropdown();
    });
  }

  if (loggedinEl !== null) {
    loggedinEl.addEventListener("click", function () {
      openNavDropdown();
    });
  }

  function openNavDropdown() {
    console.log(document.getElementById("myDropdown"));
    document.getElementById("myDropdown").classList.toggle("show");
    console.log(document.getElementById("myDropdown"));
  }

  // Close the dropdown if the user clicks outside of it
  window.onclick = function (event) {
    if (
      !document.getElementsByClassName("logged-in")[0].contains(event.target)
    ) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.classList.contains("show")) {
          openDropdown.classList.remove("show");
        }
      }
    }
  };
});
