<?php 

  if(isset($_POST['submit'])){
    $username = $_POST["username"];
    $recoveryKey = $_POST["recoveryKey"];

    require_once 'config.php';
    require_once 'functions-scripts.php';

    if(authenticateRecovery($conn, $username, $recoveryKey)){
      header("location: ../reset-password-login.php?username=".$username);
      exit();
    };

  }
  else {
    header("location: ../login.php?error=invalidaccess");
    exit();
  }


?>