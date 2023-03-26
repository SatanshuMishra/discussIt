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
    $userid = $_POST['userid'];
    $enteredUsername =  $_POST['username'];
    $enteredFirstName = $_POST['firstname'];
    $enteredLastName = $_POST['lastname'];
    $enteredDemeritPoints = $_POST['demerit-points'];
    $enteredAdministratorPerms = $_POST["isAdmin"];
    $resetprofilePicture = $_POST["reset-profile-picture"];

    if($resetprofilePicture) {
      setProfilePicture($userid);
    }

    $user = getUserByID($conn, $userid);
    if(($enteredUsername != $user["username"] || $enteredFirstName != $user["firstName"] || $enteredLastName != $user["lastName"] || $enteredDemeritPoints != $user["demeritPoints"] || $enteredAdministratorPerms != $user["administratorPermissions"])){
      if(updateUser($conn, $userid,$enteredUsername, $enteredFirstName, $enteredLastName, $enteredDemeritPoints, $enteredAdministratorPerms)){
        header("Refresh:0");
        header("Location: ../administrator-portal.php?message=updatesuccessful", true, 307);
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