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
  <link rel="stylesheet" href="css/forgotPasswordB.css">
  <!-- LOCAL JS -->
  <script src="js/showPassword.js"></script>
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title>Reset Password</title>
</head>
<body>

  <?php include_once 'components/navigation-bar-v2-no-search.php'; ?>

  <div class="container">
    <div class="image-container">
      <img id="login-illustration" src="images/reset-illustration.svg" alt="">
    </div>
    <div class="form-container">
      <h1>Reset Password</h1>
      <span class="textDescription">Please enter your new password below.</span>
      <form id="resetForm" action="scripts/reset-password-script.php" method="post">
        <input type="hidden" name="username" <?php $username = $_GET["username"]; echo "value=\"$username\""; ?>>
        <label id="new-password-label" for="new-password">New Password</label><br>
        <input type="text" name="new-password" id="new-password" required oninvalid="this.setCustomValidity('Please enter your new password.')"
       oninput="setCustomValidity('')"><br>
        <div id="recovery-label-container">
          <label id="confirm-password-label" for="confirm-password">Confirm Password</label><br>
        </div>
        <input type="text" name="confirm-password" id="confirm-password" required oninvalid="this.setCustomValidity('Please confirm your new password.')"
        oninput="setCustomValidity('')">
        <div class="buttons-container">
          <div class="cancel-btn-div">
            <a href="./login.php">
              <button type="button">
                Cancel
              </button>
            </a>
          </div>
          <button type="submit" name="submit">
            Reset
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>