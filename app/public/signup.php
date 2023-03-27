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
  <title>Sign Up</title>
</head>
<body>

  <?php include_once 'components/navigation-bar-v2-no-search.php'; ?>

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
        <input type="text" name="username" id="username" required oninvalid="this.setCustomValidity('Please enter a username.')"
       oninput="setCustomValidity('')"><br>
        <label id="passLabel" for="password">Password*</label><br>
        <div class="passwordCont">
          <input type="password" name="password" id="password" required oninvalid="this.setCustomValidity('Please enter a password.')"
        oninput="setCustomValidity('')"><br>
          <i id="showPasswordIcon" class="fa-regular fa-eye"></i>
        </div>

        <div class="terms-checkbox">
          <input type="checkbox" name="agreeToTerms" id="agreeToTerms" required oninvalid="this.setCustomValidity('You must agree to our terms & conditions to proceed.')"
       oninput="setCustomValidity('')">
          <label id="termsLabel" for="username"><a href="#">Agree to Terms and Conditons</a>&nbsp;<sup><i class="fa-solid fa-arrow-up-right-from-square"></i> </sup></label>
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
</body>
</html>