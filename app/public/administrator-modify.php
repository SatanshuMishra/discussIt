<?php session_start(); 
  if(!isset($_SESSION["uid"])){
    header("Location: ./index.php?error=invalidadminaccessnotloggedin");
    exit();
  }
  require_once "./scripts/config.php";
  require_once "./scripts/functions-scripts.php";
   
  if(!(getUserByID($conn, $_SESSION["uid"])["administratorPermissions"])){
    header("Location: ./index.php?error=invalidadminaccessnotadmin");
    exit();
  }

  if(!isset($_GET["userId"])){
    header("Location: ./administrator-modify.php?error=invalidaccessmodifyuser");
    exit();
  }

  $sessionUser = getUserByID($conn, $_SESSION["uid"]);
  $userModify = getUserByID($conn, $_GET["userId"]);

  header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/administrator-modify.css">
  <!-- LOCAL JS -->
  <!-- <script src="js/admin-portal.js"></script> -->
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title>Admin Portal</title>
</head>
<body>
  <nav class="nav-sidebar">
    <div class="upper-section">
      <div class="logo-container">
        <img class="logo" src="./images/logoDarkBlue.png" alt="">
      </div>
      <!-- <hr class="solid"> -->
      <ul class="nav-list">
        <a class="disabled">
          <li class="nav-option">
            <i class="fa-solid fa-chart-pie"></i>
          </li>
        </a>
        <a class="disabled">
          <li class="nav-option">
            <i class="fa-regular fa-envelope"></i>
          </li>
        </a>
      </ul>
      <!-- <hr class="solid"> -->
      <ul class="nav-list">
        <a href="./administrator-portal.php">
          <li class="nav-option active">
            <i class="fa-regular fa-user"></i>
          </li>
        </a>
        <a href="./administrator-discussions.php">
          <li class="nav-option">
            <i class="fa-regular fa-message"></i>
          </li>
        </a>
      </ul>
    </div>
    <div class="lower-section">
      <div class="profile-image-conatainer">
        <img <?php echo 'src="./uploads/profile-'.$_SESSION["uid"].'.png?version=1231231"' ?> alt="ProflePicture">
      </div>
      <div class="exit-container">
        <a href="./index.php">
          <i class="fa-solid fa-door-open"></i>
        </a>
      </div>
    </div>
  </nav>
  <div class="content">
    <div class="header-container">
      <div class="view-info-container">
        <div class="icon-container">
          <i class="fa-solid fa-brush"></i>
        </div>
        <span>Modify Account</span>
      </div>
    </div>
    <div class="edit-container">
      <form action="./scripts/admin-update-user.php" method="post">
        <div class="hidden-container">
          <input type="hidden" name="userId" value="<?php echo $userModify["id"] ?>">
        </div>

        <div class="user-information">
          <img src="./uploads/profile-<?php echo $userModify["id"] ?>.png" alt="profile-picture-modal">
          <div class="user-info-text">
            <h1><?php echo $userModify["firstName"]." ".$userModify["lastName"] ?></h1>
            <div class="reset-profile-picture">
              <label class="input-label" for="picture-reset">Reset Profile Picture</label>
              <input class="checkbox" type="checkbox" name="picture-reset" id="picture-reset">
            </div>
          </div>
        </div>

        <div class="name-container row-container">
          <div class="firstname-container input-container">
            <label class="input-label" for="firstname">Firstname</label>
            <input class="input-field" type="text" name="firstname" id="firstname" value="<?php echo $userModify["firstName"] ?>">
          </div>
          <div class="lastname-container input-container">
            <label class="input-label" for="lastname">Lastname</label>
            <input class="input-field" type="text" name="lastname" id="lastname" value="<?php echo $userModify["lastName"] ?>">
          </div>
        </div>

        <div class="credentials-container row-container">
          <div class="username-container input-container">
            <label class="input-label" for="username">Username</label>
            <input class="input-field" type="text" name="username" id="username" value="<?php echo $userModify["username"] ?>">
          </div>
          <div class="password-container input-container">
            <label class="input-label" for="reset-password">Reset Password</label>
            <input class="input-field" type="number" min="0" max="1" name="reset-password" id="reset-password" value="0">
          </div>
        </div>

        <div class="additional-container row-container">
          <div class="demerit-container input-container">
            <label class="input-label" for="demerit-points">Demerit Points</label>
            <input type="number" class="input-field"  min="0" max="3" name="demerit-points" id="demerit-points" value="<?php echo $userModify["demeritPoints"] ?>">
          </div>
          <div class="permissions-container input-container">
            <label class="input-label" for="permissions">Permissions</label>
            <select id="permissions" name="permissions">
              <option value="0">Member</option>
              <option <?php echo ($userModify["administratorPermissions"]) ? 'selected="selected"' : "" ?> value="1">Administrator</option>
            </select>
          </div>
        </div>

        <div class="options-container row-container">
          <a href="./administrator-portal.php">
            <button class="style-button cancel-button" type="button">Cancel</button>
          </a>
          <button class="style-button reset-button" type="reset">Reset Form</button>  
          <button class="style-button submit-button" type="submit" name="submit">Submit Changes</button>
        </div>
      </form>
    </div>
  </div>
</body>
</html>