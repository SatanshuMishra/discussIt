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
    $enteredUsername =  $_POST['username'];
    $enteredFirstName = $_POST['firstname'];
    $enteredLastName = $_POST['lastname'];
    $resetPassword = $_POST['reset-password'];
    $enteredDemeritPoints = $_POST['demerit-points'];
    $permissions = $_POST["permissions"];
    $resetprofilePicture = (isset($_POST["picture-reset"])) ? $_POST["picture-reset"] : false;

    $user = getUserByID($conn, $userid);

    // TODO: ADD $resetPassword to the IF COND
    if(($enteredUsername != $user["username"] || $enteredFirstName != $user["firstName"] || $enteredLastName != $user["lastName"] || $enteredDemeritPoints != $user["demeritPoints"] || $permissions != $user["administratorPermissions"]) || $resetprofilePicture){
      if(updateUser($conn, $userid, $enteredUsername, $enteredFirstName, $enteredLastName, $enteredDemeritPoints, $permissions)){
        if($_SESSION["uid"] == $userid){
          $_SESSION["uname"] = $enteredUsername;
        }
        if($resetprofilePicture) {
          setProfilePicture($userid);
        }
        if($resetPassword){
          // TODO: IMPLEMENT RESET PASSWORD
        }
        header("Location: ../administrator-portal.php?message=updatesuccessful");
        exit();
      } else {
        header("Location: ../administrator-portal.php?message=updatefail");
        exit();
      }
    } else {
      header("Location: ../administrator-portal.php?message=nothingtochange");
      exit();
    }
  }
  else {
    header("location: ../index.php?error=invalidaccessadminupdate");
    exit();
  }
?>