<?php session_start();

  if(!isset($_SESSION["uid"])){
    header("Location: ./index.php?invalidadminaccessnotloggedin");
    exit();
  }
  require_once "./config.php";
  require_once "./functions-scripts.php";
   
  if(!(getUserByID($conn, $_SESSION["uid"])["administratorPermissions"])){
    header("Location: ./index.php?invalidadminaccessnotadmin");
    exit();
  }

  if(isset($_POST['submit'])){
    $userid = $_POST['userId'];
    $enteredFirstName = $_POST['firstname'];
    $enteredLastName = $_POST['lastname'];

    $user = getUserByID($conn, $userid);

    if($enteredFirstName != $user["firstName"] || $enteredLastName != $user["lastName"]){
      if(updateUserName($conn, $userid, $enteredFirstName, $enteredLastName)){
        header("Location: ../SettingsDirectory.php?message=updatesuccessful");
        exit();
      } else {
        header("Location: ../SettingsDirectory.php?message=updatefail");
        exit();
      }
    } else {
      header("Location: ../SettingsDirectory.php?message=nothingtochange");
      exit();
    }
  } else {
    header("location: ../index.php?error=invalidaccess");
    exit();
  }
?>
