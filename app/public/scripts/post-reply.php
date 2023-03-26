<?php session_start();
  if(isset($_POST['submit'])){
    $replyContent = $_POST["post-reply-content"];
    $discussionId = $_GET["id"];
    $authorId = $_SESSION["uid"];

    require_once 'config.php';
    require_once 'functions-scripts.php';

    postReply($conn,$authorId, $discussionId, $replyContent);
    header("location: ../discussion.php?id=$discussionId");
    exit();

  }
  else {
    header("location: ../login.php");
    exit();
  }
?>