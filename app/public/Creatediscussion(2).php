<?php session_start();
?>
<!DOCTYPE html>
<html lang= "en">
<head>
    <!-- EXTERNAL CSS -->
    <link rel="stylesheet" href="css/Creatediscussion(2).css">
    <!-- HEADER INCLUDE -->
    <?php include_once "./includes/header-information.php"; ?>
    <title>Create a Discussion</title>
</head>
<body>
    <!--<script src = "discussion(2).js"></script>-->
    <?php include 'components/navigation-bar-no-search.php'; ?>
<div class = "circles-container">
    <div class = "circle">
        1
    </div>
    <div class = "circle2">
        2
    </div>
    <div class = "circle3">
        3
    </div>
</div>
<h1>Discussion Details</h1>

<form action = "../scripts/passDiscussInfo.php" method = "post">
    <div class = "title">
        <label for = "postTitle">Post Title</label>
        <br>
        <textarea type = "text" id = "postTitle" name = "postTitle"></textarea>
    </div>
    <div class = "content">
        <label for = "content">Post Content</label>
        <br>
        <textarea type = "text" id = "content" name = "content"></textarea>

    </div>
   <!-- <div class = "review-post">
    <button class = "review">Review Post</button></a>
    </div>
-->
    <div class = "review-post-btn">
    <button class = "review" type = "submit" name = "submit" value = "Submit">Review Post</button>
  </div>
</form>

<div class = "buttons">
    <div class = "cancel-button">
  <a href = "index.php"><button class = "cancel">Cancel</button></a>
    </div>
    <div class = "previous-page">
    <a href = "discussion.php"><button class = "previous">Previous Page</button></a>
    </div>
</div>



</body>
</html>