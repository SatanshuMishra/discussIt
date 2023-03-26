<?php 

  if(isset($_POST['submit'])){
    $uname = $_POST["username"];
    $pwd = $_POST["password"];

    require_once 'config.php';
    require_once 'functions-scripts.php';

    loginUser($conn, $uname, $pwd);
  }
  else {
    header("location: ../login.php");
    exit();
  }


?>