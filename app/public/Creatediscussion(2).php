<?php session_start();?>
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
    <!-- <script src="discussion(2).js"></script> -->
  <?php include_once 'components/navigation-bar-v2-no-search.php'; ?>
  <div class="indicator-container">
    <div class="progress-indicator">
        <span>1</span>
    </div>
    <div class="progress-indicator current-page">
        <span>2</span>
    </div>
    <div class="progress-indicator">
        <span>3</span>
    </div>
  </div>
  <div class="header-container">
    <h1>What do you want to discuss?</h1>
    <span>Enter the details of your post.</span> 
    <div class="information-container">
      <span><i class="fa-solid fa-circle-question"></i> &nbsp;<b>Note</b>: Ensure that your post is in line with our <a class="disabled" style="text-decoration: underline; color: #fff">Terms & Conditions</a>. Posts that violate them may be subject to review and/or be removed.</span>
    </div>  
  </div>

  <div class="body-container">
    <form action="../scripts/passDiscussInfo.php" method="post">
        <div class="post-container">
            <label for="postTitle">Post Title</label>
            <textarea rows="1" class="textarea-formatter" type="text" id="postTitle" name="postTitle" placeholder="Enter Post Title" required oninvalid="this.setCustomValidity('Please enter a post title.')"
       oninput="setCustomValidity('')"></textarea>
        </div>
        <div class="post-container">
            <label for="content">Post Content</label>
            <br>
            <textarea class="textarea-formatter" rows="5" type="text" id="content" name="content" placeholder="Enter Post Body" required oninvalid="this.setCustomValidity('Please add your post content.')"
       oninput="setCustomValidity('')"></textarea>
        </div>
        <div class="progression-btn-container">
            <div class="cancel-button">
                <a href="index.php"><button type="button" class="btn-formatted  cancel">Cancel</button></a>
            </div>
            <div class="previous-page">
                <a href="Creatediscussion.php"><button type="button" class="btn-formatted  previous">Previous Page</button></a>
            </div>
            <div class="review-post-btn">
                <button class="btn-formatted  review" type="submit" name="submit" value="Submit">Review Post</button>
            </div>
        </div>
    </form>
  </div>





</body>
</html>