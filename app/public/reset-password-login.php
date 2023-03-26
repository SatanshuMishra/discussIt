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
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="images/logoDarkBlue.png">
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/forgotPasswordB.css">
  <!-- EXTERNAL SCRIPTS -->
  <script src="https://kit.fontawesome.com/ec7e0e3eb8.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.js"
integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
  <script src="js/showPassword.js"></script>
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