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
    if(removeUserByID($conn, $userid)){
      header("Refresh:0");
      header("Location: ../administrator-portal.php?message=usersuccessfullyremoved", true, 307);
      exit();
    } else {
      header("Location: ../administrator-portal.php?message=removeuserfailed");
      exit();
    }
  }
  else {
    header("location: ../index.php?error=invalidaccessadminuserremove");
    exit();
  }
?>