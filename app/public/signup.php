<?php 
  session_start();
  if(isset($_SESSION["uid"])){
    header("location: ../index.php?error=alreadyloggedin");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/signup.css">
  <!-- LOCAL JS -->
  <script src="js/showPassword.js"></script>
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <script src="js/showPassword.js"></script>
  <title>Sign Up</title>
</head>
<body>
  <element id="reference-element"></element>
  <?php include_once 'components/navigation-bar-v2-no-search.php'; ?>

  <div class="toast">
    <div class="toast-content">
      <i id="toast-icon-ref" class="fa-solid fa-circle-exclamation check-icon"></i>
      <!-- <i class="fa-solid fa-circle-check check-icon"></i> -->
      <div class="message">
        <span class="text text-1">Sign Up Failed</span>
        <span class="text text-2">Incorrect username or password.</span>
      </div>
    </div>
    <i class="fa-solid fa-xmark close-icon"></i>
    <div class="progress">

    </div>
  </div>

  <div class="container">
    <div class="image-container">
      <h1>Welcome to the <br> Home of Discussions</h1>
      <img id="login-illustration" src="images/sign-up-illustration.svg" alt="">
    </div>
    <div class="form-container">
      <h1>Sign Up</h1>
      <form id="signupForm" action="scripts/signup-script.php" method="post">
        <label id="firstNameLabel" for="firstName">First Name*</label><br>
        <input type="text" name="firstName" id="firstName" required oninvalid="this.setCustomValidity('Please enter a first name.')"
       oninput="setCustomValidity('')"><br>
        <label id="lastNameLabel" for="lastName">Last Name*</label><br>
        <input type="text" name="lastName" id="lastName" required oninvalid="this.setCustomValidity('Please enter a last name.')"
       oninput="setCustomValidity('')">
        <label id="usernameLabel" for="username">Username*</label><br>
        <input type="text" name="username" id="username" required oninvalid="this.setCustomValidity('Please enter a username between 6 and 30 characters.')"
       oninput="setCustomValidity('')" minlength="6" maxlengthminlength="30"><br>
        <label id="passLabel" for="password">Password*</label><br>
        <div class="passwordCont">
          <input id="password" type="password" name="password" required oninvalid="this.setCustomValidity('Please enter a password.')"
        oninput="setCustomValidity('')"><br>
          <i id="show-password" class="fa-regular fa-eye" onclick="showPassword()"></i>
        </div>

        <div class="terms-checkbox">
          <input type="checkbox" name="agreeToTerms" id="agreeToTerms" required oninvalid="this.setCustomValidity('You must agree to our terms & conditions to proceed.')"
       oninput="setCustomValidity('')">
          <label id="termsLabel" for="username"><a class="disabled">Agree to Terms and Conditons</a>&nbsp;<sup><i class="fa-solid fa-arrow-up-right-from-square"></i> </sup></label>
        </div>
        
        <div class="buttons-container">
          <div class="log-in-btn-div">
            <label id="loginLabel">Already have an account? Sign In.</label>
            <a href="./login.php">
              <button type="button">
                Sign In
              </button>
            </a>
          </div>
            <button type="submit" name="submit">
              Sign Up
            </button>
        </div>
      </form>
    </div>
  </div>
  <script>
    function showPassword() {
      var x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }

    window.addEventListener("DOMContentLoaded", (event) => {
      toast = document.querySelector(".toast");
      close = document.querySelector(".close-icon");
      progress = document.querySelector(".progress");

      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      if(urlParams.has('error')){
        let title = document.querySelector(".text-1");
        let description = document.querySelector(".text-2");
        let icon = $("#toast-icon-ref");
        if(urlParams.get('error') == "usernametaken"){
          icon.removeClass();
          icon.addClass("fa-solid fa-circle-exclamation check-icon");
          title.innerHTML= "Sign Up Failed";
          description.innerHTML= "The username entered has already been taken.";
        } else if(urlParams.get('error') == "usernametooshort"){
          icon.removeClass();
          icon.addClass("fa-solid fa-circle-exclamation check-icon");
          title.innerHTML= "Username too short!";
          description.innerHTML= "The username must be between 6 and 30 characters long.";
        } else if(urlParams.get('error') == "usernametoolong"){
          icon.removeClass();
          icon.addClass("fa-solid fa-circle-exclamation check-icon");
          title.innerHTML= "Username too long!";
          description.innerHTML= "The username must be between 6 and 30 characters long.";
        } else {
          title.innerHTML = "Title";
          description.innerHTML = "This is a generic message!";
        }

        setTimeout(() => {
          toast.classList.add("active");
          progress.classList.add("active");
          
          setTimeout(() => {
            toast.classList.remove("active");
          }, 5000);
        }, 50);
      }

      close.addEventListener("click", () => {
        toast.classList.remove("active");
      })
    });
  </script>
  <?php include_once "./components/footer.php"; ?>
</body>
</html>