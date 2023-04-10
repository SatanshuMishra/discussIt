<?php session_start();
  if(!isset($_GET["id"])){
    header("location: index.php?error=discussionnotfound");
    exit();
  }
  require_once 'scripts/config.php';
  require_once 'scripts/functions-scripts.php';

  $discussionId = $_GET["id"];
  $discussion = getDiscussion($conn, $discussionId);

  if(!$discussion){
    header("location: index.php?error=discussionnotfound");
    exit();
  }
  
  if(!$discussion["isVisible"] && !(isset($_SESSION["uid"]) && getUserByID($conn, $_SESSION["uid"])["administratorPermissions"])){
    header("location: index.php?error=discussionnotvisible");
    exit();
  }

  $post = getPost($conn, $discussionId);
  $topics = getTopics($conn, $discussionId);
  $replies = getReplies($conn, $discussionId);
  $numofReplies = getRepliesCount($conn,$discussionId);
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
  <link rel="stylesheet" href="css/topic-colors.css">
  <link rel="stylesheet" href="css/discussion.css">
  <!-- LOCAL JS -->
  <script src="js/view-discussion.js"></script>
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title><?php echo $post["postTitle"] ?></title>
  <script src="js/postTiming.js"></script>
  <script src = "js/updateReplies.js"></script>
</head>
<body>
  <element id="reference-element"></element>
  <?php include_once 'components/navigation-bar-v2.php'; ?>
  <div class="toast">
    <div class="toast-content">
      <i class="fa-solid fa-circle-info check-icon"></i>
      <div class="message">
        <span class="text text-1"></span>
        <span class="text text-2"></span>
      </div>
    </div>
    <i class="fa-solid fa-xmark close-icon"></i>
    <div class="progress">
    </div>
  </div>
  <div class="modal-container">
    <?php 
      if(isset($_GET['replyId'])){
        $replyToContent = getReplyByID($conn, $_GET["replyId"]);
        $author = getUserByID($conn, $replyToContent["authorId"]);
        echo '
          <div class="modal">
            <div class="reply" style="margin: 0; border-radius: 0;">
              <div class="header">
                <img id="profile-picture-reply" src="uploads/profile-'.$author["id"].'.png"/>
                <div class="user-info">
                  <span class="username">'.$author["firstName"]." ".$author["lastName"].'</span>
                </div>
              </div>
              <div class="body">
                '.$replyToContent["content"].'
              </div>
            </div>
            <form action="scripts/post-reply.php?id='.$discussionId.'" method="post">
              <input type="hidden" name="replyToId" value="'.$replyToContent["id"].'">
              <textarea id="post-reply" name="post-reply-content" rows="1" placeholder="Post a Reply"></textarea>
              <div class="post-btn-cont">
                <button id="modal-cancel-btn" type="button" name="cancel">Cancel</button>
                <button id="post-reply-btn" type="submit" name="submit">Send</button>
              </div>
            </form>
          </div>

          <script>$(\'.modal-container\').css(\'display\', \'block\');</script>
        ';
      }
    ?>
  </div>
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
            $createdAt = strtotime($post["createdAt"]);
             echo "<script type=\"text/javascript\">  
              dynamicTiming('timeSincePost-$discussionId','$createdAt');
                        setInterval(function(){
                        dynamicTiming('timeSincePost-$discussionId','$createdAt')
                      }, 60000);
                </script>"; 
            echo "<img id=\"profile-picture-post\" src=\"uploads/profile-$postUserId.png\"/>";
          ?>
          <!-- <span style="font-size: 40px; padding-top: 8px;"><i class="fa-regular fa-circle-user"></i></span> -->
          <div class="details">
            <p class="name"><a class="remove-decoration" href="./previewaccount.php?userid=<?php echo $post["id"];?>"><?php echo $post["username"]; ?></a></p>
            <p class="date"><?php echo "<span id =\"timeSincePost-$discussionId\"</span></p>"; ?>
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
            if($numofReplies != 0){
            echo $numofReplies["numReplies"];
            }else{
              echo 0;
            }
            ?>
          </div>
        </sup>
      </div>
      <div class="post-reply">
        <?php
          if(isset($_SESSION["uid"])){
            if(getUserByID($conn, $_SESSION["uid"])["isSuspended"]) {
              echo '
              <div class="not-logged-in">
                <h1>Your account as been suspended. You cannot post a comment!</h1>
              </div>
              ';
            } else {
              echo '
              <form action="scripts/post-reply.php?id=' , $discussionId , '" method="post">
                <textarea id="post-reply" name="post-reply-content" rows="1" placeholder="Post a Reply"></textarea>
                <div class="post-btn-cont">
                  <button id="post-reply-btn" type="submit" name="submit">Send</button>
                </div>
              </form>
              ';
            }
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
      <div class="user-replies" id = "user-replies">
        <?php
         echo "<script type=\"text/javascript\">  
         updateReplies('$discussionId');
                   setInterval(function(){
                  updateReplies('$discussionId')
                }, 30000);
         </script>";
        
        ?>       
      </div>
    </div>
  </div>
  </div>
  <?php include_once "./components/footer.php"; ?>
  <script id="reply-reply-script"></script>
  <script>
    $(document).ready(function(){
      $('#modal-cancel-btn').click(() => {
        $('.modal-container').css('display', 'none');
      });

      let toast = document.querySelector(".toast");
      let close = document.querySelector(".close-icon");
      let progress = document.querySelector(".progress");

      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      if(urlParams.has('message')){
        let title = document.querySelector(".text-1");
        let description = document.querySelector(".text-2");
        if(urlParams.get('message') == "replySuccessfullyPosted"){
          title.innerHTML= "Success!";
          description.innerHTML= "Reply was posted successfully!";
        } else if(urlParams.get('message') == "postSuccessfullyCreated"){
          title.innerHTML= "Success!";
          description.innerHTML= "Your post was created successfully!";
        }
        setTimeout(() => {
          toast.classList.add("active");
          progress.classList.add("active");
          
          setTimeout(() => {
            toast.classList.remove("active");
          }, 5000);
        }, 50);
      }

      close.addEventListener("click", () => {
        toast.classList.remove("active");
      })
    });
  </script>
</body>
</html>