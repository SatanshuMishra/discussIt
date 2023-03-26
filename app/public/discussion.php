<?php session_start();
  if(!isset($_GET["id"])){
    header("location: index.php?error=discussionnotfound");;
  }
  require_once 'scripts/config.php';
  require_once 'scripts/functions-scripts.php';

  $discussionId = $_GET["id"];
  $discussion = getDiscussion($conn, $discussionId);

  if(!$discussion){
    header("location: index.php?error=discussionnotfound");;
  }
  
  $post = getPost($conn, $discussionId);
  $topics = getTopics($conn, $discussionId);
  $replies = getReplies($conn, $discussionId);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="images/logoDarkBlue.png">
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/discussion.css">
  <!-- EXTERNAL SCRIPTS -->
  <script src="https://kit.fontawesome.com/ec7e0e3eb8.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.js"
integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
  <title><?php echo $post["postTitle"] ?></title>
</head>
<body>
  <script src="js/discussion.js"></script>
  <?php include_once 'components/navigation-bar-v2.php'; ?>
  <div class="organiser">
  <div class="post-reply-cont">
    <div class="post">
      <div class="header">
        <h1><?php echo $post["postTitle"]; ?></h1>
        <div class="topics">
          <?php
              foreach($topics as $arr){
                foreach($arr as $topic){
                  $tag = strtolower($topic);
                  echo"
                  <div class=\"pill $tag\">
                    <span class=\"name\">$topic</span>
                  </div>
                  ";
                }
              }
          ?>
        </div>
      </div>
      <div class="body">
        <p class="content">
          <?php echo $post["postContent"]; ?>
        </p>
      </div>
      <div class="footer">
        <div class="reactions">
          <!-- <div class="comments">
            <i class="fa-regular fa-comment-dots"></i>
            <span class="number">90</span>
          </div> -->
          <div class="popularity">
            <i class="fa-regular fa-heart"></i>
            <span class="number"><?php echo $discussion["rankingIndex"];?></span>
          </div>
        </div>
        <div class="user-info">
          <?php 
            $postUserId = $post["id"];
            echo "<img id=\"profile-picture-post\" src=\"uploads/profile-$postUserId.png\"/>";
          ?>
          <!-- <span style="font-size: 40px; padding-top: 8px;"><i class="fa-regular fa-circle-user"></i></span> -->
          <div class="details">
            <p class="name"><?php echo $post["username"]; ?></p>
            <p class="date"><?php echo date('Y-m-d', strtotime($post["createdAt"])); ?></p>
          </div>
        </div>
      </div>
    </div>
    <div class="replies">
      <div class="header">
        <h1>Comments</h1>
        <sup>
          <div class="reply-count">
            <?php 
            if($replies)
              echo count($replies); 
            else
              echo 0;  
            ?>
          </div>
        </sup>
      </div>
      <div class="post-reply">
        <?php
           if(isset($_SESSION["uid"])){
            echo '
            <form action="scripts/post-reply.php?id=' , $discussionId , '" method="post">
              <textarea id="post-reply" name="post-reply-content" rows="1" placeholder="Post a Reply"></textarea>
              <div class="post-btn-cont">
                <button id="post-reply-btn" type="submit" name="submit">Send</button>
              </div>
            </form>
            ';
           } else{
            echo '
            <div class="not-logged-in">
              <h1>You need to log in to post a comment.</h1>
              <a href="../login.php"><button class="login-post-btn">Log In</button></a>
            </div>
            ';
           }
        ?>
      </div>
      <div class="user-replies">
        <?php 
        if($replies){
          foreach($replies as $reply){
              $replyUserId = $reply["id"];
              $username = $reply["username"];
              $replyContent = $reply["content"];
              $time = date('Y-m-d', strtotime($reply["createdAt"]));;
              echo "
              <div class=\"reply\">
                <div class=\"header\">
                  <img id=\"profile-picture-reply\" src=\"uploads/profile-$replyUserId.png\"/>
                  <div class=\"user-info\">
                    <span class=\"username\">$username</span>
                  </div>
                </div>
                <div class=\"body\">
                  $replyContent
                </div>
                <div class=\"footer\">
                  <span class=\"time\">$time</span>
                </div>
              </div>
              ";
          }
        }
        ?>
        <!-- <div class="reply">
          <div class="header">
            <span style="font-size: 40px;">
              <i class="fa-regular fa-circle-user"></i>
            </span>
            <div class="user-info">
              <span class="username">Satanshu Mishra</span>
            </div>
          </div>
          <div class="body">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer et tellus et purus accumsan fringilla nec ac nunc. Vivamus ac nibh nec erat sagittis bibendum eget vitae ipsum. Proin rhoncus pharetra orci, a luctus nisi pulvinar a. Nam ut risus eget mi egestas aliquet.
          </div>
          <div class="footer">
            <span class="time">15hr</span>
          </div>
        </div> -->
      </div>
    </div>
  </div>
  </div>
</body>
</html>