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
  <link rel="stylesheet" href="css/forgotPasswordA.css">
  <!-- EXTERNAL SCRIPTS -->
  <script src="https://kit.fontawesome.com/ec7e0e3eb8.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.js"
integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
  <script src="js/showPassword.js"></script>
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