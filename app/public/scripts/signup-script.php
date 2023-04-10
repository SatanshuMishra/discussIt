<?php
// CHECK IF USER GOT TO THE PAGE THROUGH SIGN-UP
if(isset($_POST["submit"])){

  $firstName = trim(strip_tags($_POST["firstName"]));
  $lastName = trim(strip_tags($_POST["lastName"]));
  $username = trim(strip_tags($_POST["username"]));
  $password = trim(strip_tags($_POST["password"]));

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

  if(strlen($username) < 6){
    header("location: ../signup.php?error=usernametooshort");
    exit();
  }

  if(strlen($username) > 30){
    header("location: ../signup.php?error=usernametoolong");
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