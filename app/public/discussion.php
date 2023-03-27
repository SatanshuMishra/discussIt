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
  $numberOfReactions = getNumberOfReactions($conn, $discussionId);

  $uid = false;
  $reacted = false;

  if(isset($_SESSION["uid"])){
    $uid = $_SESSION["uid"];
    $reacted = checkIfReacted($conn, $uid, $discussionId);
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/discussion.css">
  <!-- LOCAL JS -->
  <script src="js/view-discussion.js"></script>
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title><?php echo $post["postTitle"] ?></title>
</head>
<body>
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
            <?php 
              if($uid){
                echo "
                    <a href=\"scripts/react-script.php?redirectTo=../discussion.php?id=$discussionId&userid=$uid&discussid=$discussionId&hasReacted=", ($reacted) ? "1" : "0","\">
                      <div class=\"popularity\">
                        ",($reacted) ? "<i class=\"fa-solid fa-heart solid-red-color\"></i>" : "<i class=\"fa-regular fa-heart\"></i>","
                        <span class=\"number\">$numberOfReactions</span>
                      </div>
                    </a>";
              } else {
                echo "
                  <div class=\"popularity\">
                    <i class=\"fa-regular fa-heart\"></i>
                    <span class=\"number\"><?php echo $numberOfReactions;?></span>
                  </div>
                ";
              }
            ?>

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