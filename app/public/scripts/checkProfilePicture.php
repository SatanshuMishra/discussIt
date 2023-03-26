<?php 
  require_once 'scripts/config.php';
  require_once 'scripts/functions-scripts.php';
  $id = $_SESSION["uid"];
  $profilePictureStatus = getProfilePictureStatus($conn, $id);
  $hasProfilePicture = $profilePictureStatus["status"] == 1;
?>