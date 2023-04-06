<?php session_start();
  if(isset($_POST['submit'])){
    $replyTo = $_POST['replyToId'];
    $replyContent = $_POST["post-reply-content"];
    $discussionId = $_GET["id"];
    $authorId = $_SESSION["uid"];

    require_once 'config.php';
    require_once 'functions-scripts.php';

    postReply($conn, $replyTo, $authorId, $discussionId, $replyContent);
    header("location: ../discussion.php?id=$discussionId");
    exit();

  }
  else {
    header("location: ../login.php");
    exit();
  }
?>