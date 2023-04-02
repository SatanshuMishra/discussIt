<?php 
  session_start();
  require_once "./includes/functions.php";
  $discussions = getDiscussions($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/discover.css">
  <!-- LOCAL JS -->
  <script src="js/discover.js"></script>
  <script src="js/postTiming.js"></script>
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>

  <title>Discover</title>
</head>
<body>
  <?php include_once 'components/navigation-bar-v2.php'; ?>

  <div class="topics-container">
    <div class="topic-slider">
      <div class="slider">
        <a class="slider-item" onclick="updateDiscussions(2)">
          <div class="item-container space">
            <span>SPACE</span>
          </div>
        </a>
        <a class="slider-item" onclick="updateDiscussions(4)">
          <div class="item-container q&a">
            <span>Q&A</span>
          </div>
        </a>
        <a class="slider-item" onclick="updateDiscussions(5)">
          <div class="item-container gaming">
            <span>GAMING</span>
          </div>
        </a>
        <a class="slider-item" onclick="updateDiscussions(6)">
          <div class="item-container cooking">
            <span>COOKING</span>
          </div>
        </a>
        <a class="slider-item" onclick="updateDiscussions(3)">
          <div class="item-container sports">
            <span>SPORTS</span>
          </div>
        </a>
        <a class="slider-item" onclick="updateDiscussions(7)">
          <div class="item-container positivity">
            <span>POSITIVITY</span>
          </div>
        </a>
        <a class="slider-item" onclick="updateDiscussions(1)">
          <div class="item-container news">
            <span>NEWS</span>
          </div>
        </a>
        <a class="slider-item" onclick="updateDiscussions(2)">
          <div class="item-container space">
            <span>SPACE</span>
          </div>
        </a>
        <a class="slider-item" onclick="updateDiscussions(4)">
          <div class="item-container q&a">
            <span>Q&A</span>
          </div>
        </a>
        <a class="slider-item" onclick="updateDiscussions(5)">
          <div class="item-container gaming">
            <span>GAMING</span>
          </div>
        </a>
        <a class="slider-item" onclick="updateDiscussions(6)">
          <div class="item-container cooking">
            <span>COOKING</span>
          </div>
        </a>
        <a class="slider-item" onclick="updateDiscussions(3)">
          <div class="item-container sports">
            <span>SPORTS</span>
          </div>
        </a>
        <a class="slider-item" onclick="updateDiscussions(1)">
          <div class="item-container news">
            <span>NEWS</span>
          </div>
        </a>
      </div>
    </div>
    <div class="slider-controls">
        <button class="slider-control-btn" id="moveSliderLeftBtn"><i class="fa-solid fa-left-long"></i></button>
        <button class="slider-control-btn" id="moveSliderRightBtn"><i class="fa-solid fa-right-long"></i></button>
    </div>
  </div>
  <div class="page-body">
    <div class="feed">
      <div class="feed-header">
        <h1>
          <span class="showing-pill sports ">FILTERED BY:</span> <span id="showing-topic">ALL</span>
        </h1>
      </div>
      <div class="feed-body" id="feed-body">
      <?php
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
      ?>
      </div>
    </div>
  </div>

  <script type="text/javascript">
    $topics = [
      "NEWS",
      "SPACE",
      "SPORTS",
      "Q&A",
      "GAMING",
      "COOKING",
      "POSITIVITY"
    ];
    function updateDiscussions(topicId){
      // $(".item-container").removeClass("active");
      // $(".space").addClass("active");
      $("#showing-topic").text($topics[topicId - 1]);
      $("#feed-body").load("./scripts/topicFilter.php", {
        id: topicId
      });
    }
  </script>
</body>
</html>