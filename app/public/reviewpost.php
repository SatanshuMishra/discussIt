<?php session_start();
$postContent = $_SESSION['content'];
$postTitle = $_SESSION['postTitle'];
$topics = $_SESSION['selectedTopics'][0];
$topicsArray = json_decode($topics,true);
$topic1 = "";
$topic2 = "";
$_SESSION['topics'] = $topicsArray;
if(count($topicsArray) > 0){
    $topic1 = $topicsArray[0];
}
if(count($topicsArray) >1){
    $topic2 = $topicsArray[1];
}
?>

<!DOCTYPE html>
<html lang= "en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- CSS -->
  <link rel="stylesheet" href="css/reviewpost.css">


  <!-- Script -->
  <script src="https://kit.fontawesome.com/ec7e0e3eb8.js" crossorigin="anonymous"></script>

  <title>Review Post</title>
</head>
<body>
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
<h1>Review Post</h1>
<form action = "../scripts/createPost-script.php" method="post">
    <label for = "topics" class = "label">Topics Chosen</label><br>
    <input type = "text" name = "topics" class="inputfield" value = "<?php if(isset($topic2)){echo" $topic1 , $topic2";}else{echo $topic1;};?> " readonly><br><br>
    <label for = "title" class = "label">Title</label><br>
    <input type = "text" name = "title" class="inputfield" value = "<?php echo"$postTitle" ?> " readonly><br><br>
    <label for = "content" class = "label">Post Content</label><br>
    <textarea type = "text" name = "content" class="inputfield-content" readonly><?php echo"$postContent" ?></textarea><br><br>
    <div class = "review-post-btn">
    <button class = "createPost" type = "submit" name = "submit" value = "Submit">Create Post</button>
  </div>
</form>






</body>
</html>