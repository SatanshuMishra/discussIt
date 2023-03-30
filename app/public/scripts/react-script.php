<?php 

  if(isset($_GET['userid']) && isset($_GET['discussid']) && isset($_GET['hasReacted'])){

    require_once 'config.php';
    require_once 'functions-scripts.php';

    $uid = $_GET["userid"];
    $discussid = $_GET["discussid"];
    $reacted = ($_GET['hasReacted'] == "1") ? true : false;


    if($reacted){
      removeReaction($conn, $uid, $discussid);
    }
    else {
      addReaction($conn, $uid, $discussid);
    }

    if(isset($_GET['redirectTo'])){
      $address = $_GET['redirectTo'];
      header("location: $address");
      exit();
    }else {
      header("location: ../index.php");
      exit();
    }
  }
  else {
    header("location: ../index.php?error=incorrectaccess");
    exit();
  }


?>