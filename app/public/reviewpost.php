<?php session_start();
$postContent=$_SESSION['content'];
$postTitle=$_SESSION['postTitle'];
$topics=$_SESSION['selectedTopics'][0];
$topicsArray=json_decode($topics,true);
$topic1="";
$topic2="";
$_SESSION['topics']=$topicsArray;
if(count($topicsArray) > 0){
    $topic1=$topicsArray[0];
}
if(count($topicsArray) >1){
    $topic2=$topicsArray[1];
}
?>

<!DOCTYPE html>
<html lang= "en">
<head>
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/reviewpost.css">
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title>Review Post</title>
</head>
<body>
      <?php include_once 'components/navigation-bar-v2-no-search.php'; ?>
  <div class="indicator-container">
    <div class="progress-indicator">
        <span>1</span>
    </div>
    <div class="progress-indicator">
        <span>2</span>
    </div>
    <div class="progress-indicator current-page">
        <span>3</span>
    </div>
  </div>
  <div class="header-container">
    <h1>Review your discussion</h1>
    <span>Ensure that the details of the discussion are correct! You will <b><span style="text-decoration: underline;">NOT</span></b> be able to change it after you submit!</span> 
    <div class="information-container">
      <span><i class="fa-solid fa-circle-question"></i> &nbsp;<b>Note</b>: Ensure that your post is in line with our <a class="disabled" style="text-decoration: underline; color: #fff">Terms & Conditions</a>. Posts that violate them may be subject to review and/or be removed.</span>
    </div>  
  </div>
  <div class="body-container">
    <form action="./scripts/createPost-script.php" method="post">
        <div class="post-container">
            <label for="topics" class="label">Topics Chosen</label><br>
            <input type="text" name="topics" class="text-field-formatter" value="<?php
             if (isset($topic2)){
                echo" $topic1  ,  $topic2";
            } else {
                echo $topic1;
            };
             
             ?> " readonly>
        </div>
        <div class="post-container">
            <label for="title" class="label">Title</label><br>
            <input type="text" name="title" class="text-field-formatter" value="<?php echo"$postTitle" ?> " readonly>
        </div>
        <div class="post-container">
            <label for="content" class="label">Post Content</label><br>
            <textarea type="text" name="content" class="text-field-formatter" readonly><?php echo"$postContent" ?></textarea>
        </div>
        <div class="review-post-btn">
            <button class="btn-formatted submit" type="submit" name="submit" value="Submit">Create Post</button>
        </div>
    </form>
  </div>







  <?php include_once "./components/footer.php"; ?>
</body>
</html>