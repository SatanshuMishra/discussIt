<?php session_start();
if(!isset($_SESSION["uid"])){
  header("location: index.php?error=usernotloggedin");;
}
?>

<!DOCTYPE html>
<html>
<head>
<!-- EXTERNAL CSS -->
<link rel="stylesheet" href="css/generateKey.css">
<!-- HEADER INCLUDE -->
<?php include_once "./includes/header-information.php"; ?>
<title>Generate New Recovery Key</title>
</head>

<body>
  <?php include 'components/navigation-bar-v2-no-search.php'; ?>
      <h1>Generate New Recovery Key</h1>
  <div class = container>
      <div class = inside id = right>
          <div class = "background">
              <img src = '../images/undraw_authentication_re_svpt.svg' class = passimg>
       </div>
      </div>
      <div class = inside id = left>
          <form action = "scripts/changePassword-script.php" method = "POST">
              <label for = "currentPassword">Pasword:</label>
              <input type = "text" id = "currentPassword" name = "currentPassword" required><br>

              <label for = "confirmNewUsername">New Recovery Key:</label>
              <input type = "text" id = "newKey" name = "newKey" readonly><br>
              <input type = "submit" value = "Submit">
              <button id = "cancel-btn"><a href = "settingsDirectory.php">Cancel</a></button>
          </form>
          
              
      </div>
  </div>



<?php include_once "./components/footer.php"; ?>
</body>
</html>

?>