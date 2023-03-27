<?php session_start();
  if(!isset($_SESSION["uid"])){
    header("location: index.php?error=usernotloggedin");;
  }
?>

<!DOCTYPE html>
<html>
<head>
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/changePassword.css">
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title>Change Password</title>
</head>

<body>
    <?php include 'components/navigation-bar-v2-no-search.php'; ?>
        <h1>Change Password</h1>
    <div class = container>
        <div class = inside id = right>
            <div class = "background">
                <img src = '../images/undraw_authentication_re_svpt.svg' class = passimg>
         </div>
        </div>
        <div class = inside id = left>
            <form action = "scripts/changePassword-script.php" method = "POST">
                <label for = "username">Username</label>
                <input type="text" id = "username" name = "username" required><br>
                <label for = "currentPassword">Previous Pasword:</label>
                <input type = "text" id = "currentPassword" name = "currentPassword" required><br>

                <label for = "newPassword">New Password:</label>
                <input type = "text" id = "newPassword" name = "newPassword" required><br>

                <label for = "confirmNewUsername">Confirm New Password:</label>
                <input type = "text" id = "confirmPassword" name = "confirmPassword" required><br>
                <input type = "submit" value = "Submit">
                <button id = "cancel-btn"><a href = "settingsDirectory.php">Cancel</a></button>
            </form>
            
                
        </div>
    </div>



  <?php include_once "./components/footer.php"; ?>
</body>
</html>