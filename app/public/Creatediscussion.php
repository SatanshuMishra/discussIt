<?php session_start();
  if(!isset($_SESSION["uid"])){
    header("Location: ./index.php?error=cannotcreatediscussionnotloggedin");
    exit();
  }
?>
<!DOCTYPE html>
<html lang= "en">
<head>
    <!-- EXTERNAL CSS -->
    <link rel="stylesheet" href="css/Creatediscussion.css">
    <!-- HEADER INCLUDE -->
    <?php include_once "./includes/header-information.php"; ?>
    <title>Create a Discussion</title>
</head>
<body>
  <script src ="js/discussion.js"></script>
  <?php include_once 'components/navigation-bar-v2-no-search.php'; ?>
<div class = "container">
<div class = "circle">
    1
</div>
<div class = "circle2">
    2
</div>
<div class = "circle2">
    3
</div>

</div>
<h1>Choose Your Topics</h1>


<div class = "scroll-bar">
    <div class = "topic" onclick = "addTopic(this)" style="background-color: blue;">Space</div>
    <div class = "topic" onclick = "addTopic(this)" style="background-color: red;">Gaming</div>
    <div class = "topic" onclick = "addTopic(this)" style="background-color: green;">News</div>
    <div class = "topic" onclick = "addTopic(this)" style="background-color: gray;">Q&A</div>
    <div class = "topic" onclick = "addTopic(this)" style="background-color: purple;">Sports</div>
    <div class = "topic" onclick = "addTopic(this)" style="background-color: orange;">Cooking</div>
    <div class = "topic" onclick = "addTopic(this)" style="background-color: black;">Positivity</div>
</div>
<form id = "form1" method = "POST" action = "scripts/passTopics-script.php">
<div class = "text-box">
    Selected Topics:
    <ul id = "selected-topics" name = "selected-topics"></ul>
    <input type="hidden" id = "topicsArray" name = "topicsArray[]" value = "">
  </div>
<div class = "continue-button">
    <button class = "continue" type = "submit" name = "submit" value = "Submit">Continue</button>
  </div>
</form>

<div class = "remove-button">
<button class = "remove" id = "remove" onclick = "removeTopic()">Remove</button>
  </div>
  <div class = "cancel-button">
  <a href = "index.php"><button class = "cancel">Cancel</button></a>
  </div>



</body>
</html>