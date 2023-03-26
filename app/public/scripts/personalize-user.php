<?php session_start();

  if(isset($_POST['submit'])){
    $bio = ($_POST["bio-text"] != "") ? $_POST["bio-text"] : NULL;
    $twitter = ($_POST["twitter-social"] != "") ? $_POST["twitter-social"] : NULL;
    $linkedin = ($_POST["linkedin-social"] != "") ? $_POST["linkedin-social"] : NULL;
    $pweb = ($_POST["pweb-social"] != "") ? $_POST["pweb-social"] : NULL;
    $id = $_SESSION["uid"];

    require_once 'config.php';
    require_once 'functions-scripts.php';

    if(!($bio || $twitter || $linkedin || $pweb)){
      header("location: ../welcome.php?access=nothingset;");
      exit();
    } else {
      if(personalizeUser($conn, $id, $bio, $twitter, $linkedin, $pweb)){
        header("location: ../welcome.php?access=updatesuccessful;");
        exit();
      }
    }

  }
  else {
    header("location: ../index.php?error=invalidaccesspersonalizeuser");
    exit();
  }


?>