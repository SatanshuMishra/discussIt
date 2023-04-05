<?php 
  session_start();
  include_once "scripts/getDiscussions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/index.css">
  <!-- LOCAL JS -->
  <!-- <script src="js/index.js"></script> -->
  <script src="js/postTiming.js"></script>
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>

  <title>Home of Discussions</title>
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

  <div class="page-body">
    <!-- OPTIONS -->
    <div class="feed">
      <div class="feed-header">
        <h1>Discussions & Articles</h1>
        <a id="start-discussion-btn-link" href= "Creatediscussion.php">
          <button class="start-discussion-btn">Start Discussion</button>
        </a>
      </div>
      <div class="feed-body">
      <?php
      if($discussions){
        foreach($discussions as $discussion){
          require_once "scripts/functions-scripts.php";
          
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
      ?>
      </div>
    </div>
    <div class="statistics">
      <div class="top-contributors">
        <h1>Top Contributors</h1>
        <span>Start or contribute to existing discussions.</span>
        <ul class="list">
        <?php
            if(false){
              foreach($topDiscussions as $discussionElement){
                // TODO: THIS IS THE CORRECT CODE FOR TOP CONTRIBUTORS - THIS IS THE DEFAULT VERSION
                echo '
                  <li>
                    <i class="fa-regular fa-circle-user"></i>
                    <a href="#"><span class="name">Satanshu Mishra</span></a>
                    &nbsp;
                    <i class="fa-solid fa-star"></i>
                    &nbsp;
                    <span class="score">53</span>
                  </li>
                ';
              }
            } else {
              echo '
          <div class="nothing-happening">
            <span>There\'s nothing happening right now! We will keep keep an eye out!</span>
            <img class="nothing-conversation-image" src="./images/nothing-conversation-illustration.svg" alt="Nothing Happening">
          </div>
              ';
            }
          ?>
        </ul>
      </div>
      <div class="top-discussions">
        <h1>Top Discussions</h1>
        <span>Most active discussions today.</span>
        <ul class="list">
        <?php
            $topDiscussions = getTopDiscussions($conn);
            if($topDiscussions){
              foreach($topDiscussions as $discussionElement){
                echo '
                  <li>
                    <a href="discussion.php?id='.$discussionElement["id"].'"><span class="title">'.substr($discussionElement["title"], 0, 20).'...</span></a>
                    &nbsp;
                    <i class="fa-solid fa-fire"></i>
                    &nbsp;
                    <span class="score">N/A</span>
                  </li>
                ';
              }
            } else {
              echo '
          <div class="nothing-happening">
            <span>There\'s nothing happening right now! We will keep keep an eye out!</span>
            <img class="nothing-image" src="./images/nothing-illustration.svg" alt="Nothing Happening">
          </div>
              ';
            }
          ?>

          <?php 
            //TODO: ADD TOOL-TIP TO SHOW FULL TITLE FOR EACH LINK 
          ?>
          <!-- <li>
            <a href="#"><span class="title">Something Interes...</span></a>
            &nbsp;
            <i class="fa-solid fa-fire"></i>
            &nbsp;
            <span class="score">N/A</span>
          </li> -->
        </ul>
      </div>
    </div>
  </div>
  <?php require_once "./components/footer.php" ?>
  <script type="text/javascript">
    window.addEventListener("DOMContentLoaded", (event) => {
      // let backToTop = document.querySelector(".arrow-container");
      // backToTop.addEventListener("mouseover", () => {
      //   backToTop.classList.add("fa-bounce");
      // });
      // backToTop.addEventListener("mouseout", () => {
      //   backToTop.classList.remove("fa-bounce");
      // });

      let toast = document.querySelector(".toast");
      let close = document.querySelector(".close-icon");
      let progress = document.querySelector(".progress");

      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      if(urlParams.has('error')){
        let title = document.querySelector(".text-1");
        let description = document.querySelector(".text-2");
        if(urlParams.get('error') == "usernotfound"){
          title.innerHTML= "User not found";
          description.innerHTML= "The user you are trying to view doesn't exsit.";
        } else if(urlParams.get('error') == "discussionnotfound"){
          title.innerHTML = "Discussion not found";
          description.innerHTML = "The discussion you are trying to view doesn't exsit.";
        } else if(urlParams.get('error') == "invalidadminaccessnotloggedin"){
          title.innerHTML = "Invalid Access";
          description.innerHTML = "You must be logged in to access this page.";
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