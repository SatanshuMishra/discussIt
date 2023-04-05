<?php 
  session_start();
  if(isset($_SESSION["uid"])){
    header("location: ../index.php?error=alreadyloggedin-login");
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/login.css">
  <!-- LOCAL JS -->
  <script type="text/javascript" src="./js/showPassword.js"></script>
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title>Login In</title>
</head>
<body>
  <element id="reference-element"></element>
  <?php include_once 'components/navigation-bar-v2-no-search.php'; ?>

  <div class="toast">
    <div class="toast-content">
      <i class="fa-solid fa-circle-exclamation check-icon"></i>
      <!-- <i class="fa-solid fa-circle-check check-icon"></i> -->
      <div class="message">
        <span class="text text-1">Login Failed</span>
        <span class="text text-2">Incorrect username or password.</span>
      </div>
    </div>
    <i class="fa-solid fa-xmark close-icon"></i>
    <div class="progress">

    </div>
  </div>

  <div class="container">
    <div class="image-container">
      <img id="login-illustration" src="images/login-illustration.svg" alt="">
    </div>
    <div class="form-container">
      <h1>Log In</h1>
      <form class="login-form" action="scripts/login-script.php" method="post">
        <div class="upper-container">
          <div class="username-container">
            <label class="label-element" for="username">Username</label><br>
            <input type="text" name="username" class="input-field" required oninvalid="this.setCustomValidity('Please enter a username.')" oninput="setCustomValidity('')">
          </div>
          <div class="password-container">
            <div class="label-container">
              <label class="label-element" for="password">Password</label>
              <a class="link" href="./forgot-password-login.php"><span id="forgot-pass-link">Forgot password?</span></a>
            </div>
            <div class="password-input-container">
              <input id="password" type="password" name="password" class="input-field" required oninvalid="this.setCustomValidity('Please enter your password.')"
            oninput="setCustomValidity('')"><br>
              <i id="show-password" class="show-password-icon fa-regular fa-eye"></i>
            </div>
          </div>
        </div>
        <div class="lower-container">
          <label class="label-element">Don't have an account? Sign Up.</label>
          <div class="options-container">
            <a href="./signup.php">
              <button class="btn" type="button">
                Sign Up
              </button>
            </a>
            <a>
              <button class="btn" type="submit" name="submit">
                Sign In
              </button>
            </a>
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php include_once "./components/footer.php"; ?>
  <script type="text/javascript">
    window.addEventListener("DOMContentLoaded", (event) => {
      toast = document.querySelector(".toast");
      close = document.querySelector(".close-icon");
      progress = document.querySelector(".progress");

      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      if(urlParams.has('error')){
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
</body>
</html>