<?php 
  session_start();
  if(!isset($_SESSION["uid"])){
    header("location: ../index.php?error=welcomenotloggedin");
    exit();
  }
  if(!isset($_GET["access"])){
    header("location: ../index.php?error=invalidaccesswelcome");
    exit();
  }
  require_once 'scripts/config.php';
  require_once 'scripts/functions-scripts.php';

  $user = getUserByID($conn, $_SESSION["uid"]);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="images/logoDarkBlue.png">
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/welcome.css">
  <!-- EXTERNAL SCRIPTS -->
  <script src="https://kit.fontawesome.com/ec7e0e3eb8.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.js"
integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
  <script src="js/welcome.js"></script>
  <title>Welcome</title>
</head>
<body>

  <?php include_once 'components/navigation-bar-v2-no-search.php'; ?>

  <div class="container">
    <div class="image-container">
      <img id="login-illustration" src="images/welcome-illustration.svg" alt="">
    </div>
    <div class="welcome-container">
      <h1>Welcome,<br> <?php echo $_SESSION["uname"]; ?></h1>
      <div class="keyContainer">
        <span class="description">
          This is your <b>recovery key</b>. Store it in a secure place. If you ever need to recover your account, this key will be required to authenticate your identity.
        </span>
        <h1><?php echo $user["userKey"]; ?></h1>
        <span class="description">
          Please be aware, you will not have access to this key from this point forward. However, you will be able to generate a new key from the settings menu.
        </span>
      </div>
      <div class="btnCont">
        <a href="index.php"><button class="continue-btn">
          Continue
        </button></a>
      </div>
    </div>
  </div>
</body>
</html>