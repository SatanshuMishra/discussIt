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
  <script src="js/showPassword.js"></script>
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title>Login In</title>
</head>
<body>

  <?php include_once 'components/navigation-bar-v2-no-search.php'; ?>

  <div class="container">
    <div class="image-container">
      <img id="login-illustration" src="images/login-illustration.svg" alt="">
    </div>
    <div class="form-container">
      <h1>Log In</h1>
      <form id="loginForm" action="scripts/login-script.php" method="post">
        <label id="usernameLabel" for="username">Username</label><br>
        <input type="text" name="username" id="username" required oninvalid="this.setCustomValidity('Please enter a username.')"
       oninput="setCustomValidity('')"><br>
        <div id="pass-label-cont">
          <label id="passLabel" for="password">Password</label><br>
          <a href="./forgot-password-login.php"><span id="forgot-pass-link">Forgot password?</span></a>
        </div>
        <div class="passwordCont">
          <input type="password" name="password" id="password" required oninvalid="this.setCustomValidity('Please enter your password.')"
        oninput="setCustomValidity('')"><br>
          <i id="showPasswordIcon" class="fa-regular fa-eye"></i>
        </div>
        <div class="buttons-container">
          <div class="sign-up-btn-div">
            <label id="signupLabel">Don't have an account? Sign Up.</label>
            <a href="./signup.php">
              <button type="button">
                Sign Up
              </button>
            </a>
          </div>
          <button type="submit" name="submit">
            Sign In
          </button>
        </div>
      </form>
    </div>
  </div>
   <?php include_once "./components/footer.php"; ?>
</body>
</html>