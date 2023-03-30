<?php session_start();
  if(!isset($_SESSION["uid"])){
    header("location: index.php?error=usernotloggedin");;
  }

if(isset($_GET['currentUserIncorrect'])){
    $incorrectCurrentMSG = $_GET['currentUserIncorrect'];
    echo "<script>alert('$incorrectCurrentMSG')</script>";
}
if(isset($_GET['NewUserMatchError'])){
    $incorrectCurrentMSG = $_GET['NewUserMatchError'];
    echo "<script>alert('$incorrectCurrentMSG')</script>";
}


?>

<!DOCTYPE html>
<html>
<head>
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/changeUsername.css">
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title>Change Username</title>
</head>
    <body>
    <?php include 'components/navigation-bar-v2-no-search.php'; ?>
    
    <div class = container>
        <div class = inside id = "left">
            <img src = '../images/undraw_editable_re_4l94.svg' class = usernameimg>
        
        </div>
        <div class = inside id = "right">
            <div class = "User-header">
            <h1>Change Username</h1>
            <form action = "scripts/changeUsername-script.php" method = "POST">
                <label for = "currentUsername">Current Username:</label>
                <input type = "text" id = "currentUsername" name = "currentUsername" required><br>

                <label for = "newUsername">New Username:</label>
                <input type = "text" id = "newUsername" name = "newUsername" required><br>

                <label for = "confirmNewUsername">Confirm New Username:</label>
                <input type = "text" id = "confirmUsername" name = "confirmUsername" required><br>
                <input type = "submit" value = "Submit">
                <button id = "cancel-btn"><a href = "settingsDirectory.php">Cancel</a></button>
            </form>
</div>
            
                
        </div>
    </div>

      <?php include_once "./components/footer.php"; ?>
</body>
</html>