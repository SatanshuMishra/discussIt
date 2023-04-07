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
    $discussId = $_GET["did"];
    if($message = toggleDiscussionVisibility($conn, $discussId)){
      header("Location: ../administrator-discussions.php?message=$message");
      exit();
    } else {
      header("Location: ../administrator-discussions.php?message=suspenduserfailed");
      exit();
    }
  }
  else {
    header("location: ../index.php?error=invalidaccessadminuserremove");
    exit();
  }
?>