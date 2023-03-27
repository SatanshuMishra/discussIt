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
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/welcome.css">
  <!-- LOCAL JS -->
  <script src="js/welcome.js"></script>
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
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

  <?php include_once "./components/footer.php"; ?>
</body>
</html>