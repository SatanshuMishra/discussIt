<?php
  require_once "config.php";
  require_once "functions-scripts.php";
  $isSuspended = false;
  if(isset($_SESSION['uid'])){
    $isSuspended = (getUserByID($conn, $_SESSION['uid'])["isSuspended"]) ? true : false;
  }
?>