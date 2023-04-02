<?php
session_start();
require_once "functions-scripts.php";
require_once "config.php";

$discussionforReply = $_GET["discussionId"];

$replies = getReplies($conn, $discussionforReply);

echo $replies;

?>