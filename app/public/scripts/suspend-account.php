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

  if(isset($_GET['iAFgo3q5J2hfCTv1SShA'])){
    $userid = $_GET["uid"];
    if($message = suspendUserByID($conn, $userid)){
      header("Location: ../administrator-portal.php?message=$message");
      exit();
    } else {
      header("Location: ../administrator-portal.php?message=suspenduserfailed");
      exit();
    }
  }
  else {
    header("location: ../index.php?error=invalidaccessadminuserremove");
    exit();
  }
?>