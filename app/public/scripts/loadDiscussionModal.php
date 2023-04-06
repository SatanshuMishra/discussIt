<?php 
  session_start();
  if(!isset($_SESSION["uid"])){
    header("location: ../index.php?error=notloggedin");
    exit();
  }
  if(!isset($_GET["replyid"])){
    header("location: ../index.php?error=invalidaccess");
    exit();
  }

  require_once 'config.php';
  require_once 'functions-scripts.php';

  $discussId = $_GET["discussionid"];
  $reply = getReplyByID($conn, $_GET["replyid"]);
  $replyId = $reply['id'];
  $author = getUserByID($conn, $reply['authorId']);
  $authorId = $author['id'];
  $content = $reply['content'];

  header("Location: ../discussion.php?id=$discussId&replyId=$replyId&content=$content&author=$authorId");



?>