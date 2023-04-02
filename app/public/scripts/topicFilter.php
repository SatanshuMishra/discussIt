<?php session_start();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['id'])){
      require_once 'config.php';
      require_once 'functions-scripts.php';

      $topicId = $_POST['id'];
      $discussions = getDiscussionsByTopic($conn, $topicId);

      if($discussions){
        foreach($discussions as $discussion){
          
          $isVisible = $discussion["isVisible"] == 1;
          if($isVisible){
            $discussionId = $discussion["id"];
            $authorId = $discussion["authorId"];

            $topics = getTopics($conn, $discussionId);
            $repliesCount = getRepliesCount($conn, $discussionId);

            if(!$repliesCount){
              $repliesCount = 0;
            } else {
              $repliesCount = $repliesCount["numReplies"];
            }

            $user = getUserByID($conn, $authorId);
            $username = $user["username"];

            $postTitle = $discussion["postTitle"];
            $postContent = $discussion["postContent"];
            $createdAt = strtotime($discussion["createdAt"]);
            echo "<script type=\"text/javascript\">  
              dynamicTiming('timeSincePost-$discussionId','$createdAt');
                        setInterval(function(){
                        dynamicTiming('timeSincePost-$discussionId','$createdAt')
                      }, 60000);
                </script>";
            
            

            $numberOfReactions = getNumberOfReactions($conn, $discussionId);

            $id = false;
            $reacted = false;

            if(isset($_SESSION["uid"])){
              $id = $_SESSION["uid"];
              $reacted = checkIfReacted($conn, $id, $discussionId);
            }

            echo "
            <div class=\"discussion\">
              <div class=\"header\">
                <h1>$postTitle</h1>
                <!-- <button class=\"more-options\"><i class=\"fa-solid fa-ellipsis\"></i></button> -->
              </div>
              <div class=\"info\">
                <div class=\"user-info\">
                  <!-- <img src=\"\" alt=\"\"> -->
                  <!-- <span style=\"font-size: 50px;\"><i class=\"fa-regular fa-circle-user\"></i></span> -->
                  <img id=\"profile-picture-post\" src=\"uploads/profile-$authorId.png\"/>
                  <div class=\"details\">
                    <p class=\"name\">$username</p>
                    <p class=\"date\"><span id = \"timeSincePost-$discussionId\"></span></p>
                  </div>
                </div>
                <div class=\"topics\">
                ";

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

                echo "
                </div>
              </div>
              <div class=\"body\">
                <p class=\"content\">
                $postContent
                </p>
              </div>
              <div class=\"footer\">
                <a href=\"discussion.php?id=$discussionId\">
                  <div class=\"comments\">
                    <i class=\"fa-regular fa-comment-dots\"></i>
                    <span class=\"number\">$repliesCount</span>
                  </div>
                </a>";
                
                if($id){
                  echo "
                  <a href=\"scripts/react-script.php?userid=$id&discussid=$discussionId&hasReacted=", ($reacted) ? "1" : "0","\">
                    <div class=\"popularity\">
                      ",($reacted) ? "<i class=\"fa-solid fa-heart solid-red-color\"></i>" : "<i class=\"fa-regular fa-heart\"></i>","
                      <span class=\"number\">$numberOfReactions</span>
                    </div>
                  </a>
                </div>
              </div>
              ";
                }
                else {
                  echo "
                  
                    <div class=\"popularity\">
                      <i class=\"fa-regular fa-heart\"></i>
                      <span class=\"number\">$numberOfReactions</span>
                    </div>
                  
                </div>
              </div>
              ";
                }
          }
        }
      } else {
        echo "
        <div id=\"empty-feed\">
          <span class=\"text\">Hmm. Seems like we didn't find anything!</span>
          <img src=\"images/empty-illustration.svg\" alt=\"empty\">
        </div>
        ";
      }
      
    } else {
        $url = $_SERVER["HTTP_REFERER"];
        header("location: $url?error=Nope");
        exit();
    }
  } else {
      $url = $_SERVER["HTTP_REFERER"];
      header("location: $url?error=Nope");
      exit();
  }
?>