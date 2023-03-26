<?php
// CHECK IF USER GOT TO THE PAGE THROUGH SIGN-UP
if(isset($_POST["submit"])){
  $firstName = $_POST["firstName"];
  $lastName = $_POST["lastName"];
  $username = $_POST["username"];
  $password = $_POST["password"];

  require_once 'config.php';
  require_once 'functions-scripts.php';

  if(invalidUsername($username) !== false){
    header("location: ../signup.php?error=invalidUsername");
    exit();
  }

  if(usernameExists($conn, $username) !== false){
    header("location: ../signup.php?error=usernametaken");
    exit();
  }

  // if(isStrongPassword($password) !== false){
  //   header("location: ../signup.php?error=weakpassword");
  //   exit();
  // }

  createUser($conn, $firstName, $lastName, $username, $password);

} else {
  header("location: ../signup.php");
  exit();
}
?>