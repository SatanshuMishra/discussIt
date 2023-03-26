<?php 

  if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $new_password = $_POST["new-password"];
    $confirm_password = $_POST["confirm-password"];

    require_once 'config.php';
    require_once 'functions-scripts.php';

    if($new_password == $confirm_password){
      if(changePassword($conn, $username, $new_password)){
        header("location: ../login.php?error=passwordresetsuccessful");
        exit();
      }
    } else {
      header("location: ../reset-password-login.php?error=passwordsdonotmatch");
      exit();
    }
  }
  else {
    header("location: ../login.php?error=invalidaccess");
    exit();
  }


?>