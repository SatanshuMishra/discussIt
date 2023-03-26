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
  <link rel="stylesheet" href="css/forgotPasswordA.css">
  <!-- LOCAL JS -->
  <script src="js/showPassword.js"></script>
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title>Forgot Password</title>
</head>
<body>

  <?php include_once 'components/navigation-bar-v2-no-search.php'; ?>

  <div class="container">
    <div class="image-container">
      <img id="login-illustration" src="images/forgot-illustration.svg" alt="">
    </div>
    <div class="form-container">
      <h1>Forgot Password</h1>
      <span class="textDescription">Forget your password? Don't worry, you can recover it here!</span>
      <form id="forgotForm" action="scripts/forgot-password-script.php" method="post">
        <label id="usernameLabel" for="username">Username</label><br>
        <input type="text" name="username" id="username" required oninvalid="this.setCustomValidity('Please enter a username.')"
       oninput="setCustomValidity('')"><br>
        <div id="recovery-label-container">
          <label id="recoveryLabel" for="recoveryKey">Recovery Key</label><br>
        </div>
        <input type="text" name="recoveryKey" id="recoveryKey" required oninvalid="this.setCustomValidity('Please enter your recovery key.')"
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
            Continue
          </button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>