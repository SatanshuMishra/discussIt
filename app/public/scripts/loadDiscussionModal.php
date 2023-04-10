<?php 
  session_start();
  if(!isset($_SESSION["uid"])){
    if($discussId = $_GET["discussionid"]){
      header("Location: ../discussion.php?id=$discussId&error=replynotloggedin");
      exit();
    } else {
      header("Location: ../index.php?error=invalidaccess");
      exit();
    }
  }
  if(!isset($_GET["replyid"])){
    header("Location: ../index.php?error=invalidaccess");
    exit();
  }

  require_once 'config.php';
  require_once 'functions-scripts.php';

  $discussId = $_GET["discussionid"];
  $replyId = getReplyByID($conn, $_GET["replyid"])["id"];

  header("Location: ../discussion.php?id=$discussId&replyId=$replyId");
?>