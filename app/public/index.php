<?php 
  session_start();
include_once "scripts/getDiscussions.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="images/logoDarkBlue.png">
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/index.css">
  <!-- EXTERNAL SCRIPTS -->
  <script src="https://kit.fontawesome.com/ec7e0e3eb8.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.js"
integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
  <title>Home of Discussions</title>
<script src="js/index.js"></script>
<script src="js/postTiming.js"></script>



</head>
<body>
<?php include_once 'components/navigation-bar-v2.php'; ?>
  
  <div class="topics-container">
    <div class="topic-slider">
      <div class="slider">
        <a class="slider-item" href="#">
          <div class="item-container space">
            <span>SPACE</span>
          </div>
        </a>
        <a class="slider-item" href="#">
          <div class="item-container q&a">
            <span>Q&A</span>
          </div>
        </a>
        <a class="slider-item">
          <div class="item-container gaming">
            <span>GAMING</span>
          </div>
        </a>
        <a class="slider-item" href="#">
          <div class="item-container cooking">
            <span>COOKING</span>
          </div>
        </a>
        <a class="slider-item" href="#">
          <div class="item-container sports">
            <span>SPORTS</span>
          </div>
        </a>
        <a class="slider-item" href="#">
          <div class="item-container positivity">
            <span>POSITIVITY</span>
          </div>
        </a>
        <a class="slider-item" href="#">
          <div class="item-container news">
            <span>NEWS</span>
          </div>
        </a>
        <a class="slider-item" href="#">
          <div class="item-container space">
            <span>SPACE</span>
          </div>
        </a>
        <a class="slider-item" href="#">
          <div class="item-container q&a">
            <span>Q&A</span>
          </div>
        </a>
        <a class="slider-item">
          <div class="item-container gaming">
            <span>GAMING</span>
          </div>
        </a>
        <a class="slider-item" href="#">
          <div class="item-container cooking">
            <span>COOKING</span>
          </div>
        </a>
        <a class="slider-item" href="#">
          <div class="item-container sports">
            <span>SPORTS</span>
          </div>
        </a>
        <a class="slider-item" href="#">
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
            $repliesCount = getRepliesCount($conn, $discussionId)["numReplies"];

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
                <button class=\"more-options\"><i class=\"fa-solid fa-ellipsis\"></i></button>
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
          <li>
            <i class="fa-regular fa-circle-user"></i>
            <a href="#"><span class="name">Satanshu Mishra</span></a>
            &nbsp;
            <i class="fa-solid fa-star"></i>
            &nbsp;
            <span class="score">53</span>
          </li>
          <li>
            <i class="fa-regular fa-circle-user"></i>
            <a href="#"><span class="name">Corrine Fairchild</span></a>
            &nbsp;
            <i class="fa-solid fa-star"></i>
            &nbsp;
            <span class="score">53</span>
          </li>
          <li>
            <i class="fa-regular fa-circle-user"></i>
            <a href="#"><span class="name">Alice Smith</span></a>
            &nbsp;
            <i class="fa-solid fa-star"></i>
            &nbsp;
            <span class="score">53</span>
          </li>
          <li>
            <i class="fa-regular fa-circle-user"></i>
            <a href="#"><span class="name">Camron Brigham</span></a>
            &nbsp;
            <i class="fa-solid fa-star"></i>
            &nbsp;
            <span class="score">53</span>
          </li>
          <li>
            <i class="fa-regular fa-circle-user"></i>
            <a href="#"><span class="name">Lilly Page</span></a>
            &nbsp;
            <i class="fa-solid fa-star"></i>
            &nbsp;
            <span class="score">53</span>
          </li>
          <li>
            <i class="fa-regular fa-circle-user"></i>
            <a href="#"><span class="name">Sam Williams</span></a>
            &nbsp;
            <i class="fa-solid fa-star"></i>
            &nbsp;
            <span class="score">53</span>
          </li>
          <li>
            <i class="fa-regular fa-circle-user"></i>
            <a href="#"><span class="name">Satanshu Mishra</span></a>
            &nbsp;
            <i class="fa-solid fa-star"></i>
            &nbsp;
            <span class="score">53</span>
          </li>
          <li>
            <i class="fa-regular fa-circle-user"></i>
            <a href="#"><span class="name">Corrine Fairchild</span></a>
            &nbsp;
            <i class="fa-solid fa-star"></i>
            &nbsp;
            <span class="score">53</span>
          </li>
          <li>
            <i class="fa-regular fa-circle-user"></i>
            <a href="#"><span class="name">Alice Smith</span></a>
            &nbsp;
            <i class="fa-solid fa-star"></i>
            &nbsp;
            <span class="score">53</span>
          </li>
          <li>
            <i class="fa-regular fa-circle-user"></i>
            <a href="#"><span class="name">Camron Brigham</span></a>
            &nbsp;
            <i class="fa-solid fa-star"></i>
            &nbsp;
            <span class="score">53</span>
          </li>
          <li>
            <i class="fa-regular fa-circle-user"></i>
            <a href="#"><span class="name">Lilly Page</span></a>
            &nbsp;
            <i class="fa-solid fa-star"></i>
            &nbsp;
            <span class="score">53</span>
          </li>
          <li>
            <i class="fa-regular fa-circle-user"></i>
            <a href="#"><span class="name">Sam Williams</span></a>
            &nbsp;
            <i class="fa-solid fa-star"></i>
            &nbsp;
            <span class="score">53</span>
          </li>
          <li>
            <i class="fa-regular fa-circle-user"></i>
            <a href="#"><span class="name">Sam Williams</span></a>
            &nbsp;
            <i class="fa-solid fa-star"></i>
            &nbsp;
            <span class="score">53</span>
          </li>
        </ul>
      </div>
      <div class="top-discussions">
        <h1>Top Discussions</h1>
        <span>Most active discussions this week.</span>
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
<script>


</script>
  

</body>
</html>