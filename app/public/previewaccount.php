<?php session_start();
  if(!isset($_GET["userid"])){
    header("location: index.php?error=usernotfound");;
  }
  require_once 'scripts/config.php';
  require_once 'scripts/functions-scripts.php';

  $uid = $_GET["userid"];
  $user = getUserByID($conn, $uid);
  $contributions = getContributionsByAuthor($conn, $uid);
  $countDiscussions = ($discussionsCreated = getDiscussionByAuthorId($conn, $uid)) ? count($discussionsCreated) : 0;
  $countReplies = ($repliesCreated = getRepliesByAuthorId($conn, $uid)) ? count($repliesCreated) : 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="images/logoDarkBlue.png">
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/previewaccount.css">
  <!-- EXTERNAL SCRIPTS -->
  <script src="https://kit.fontawesome.com/ec7e0e3eb8.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.js"
integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
  <script src="js/showPassword.js"></script>
  <title><?php echo $user["username"]; ?></title>
</head>
<body>
  <?php include_once 'components/navigation-bar-v2-no-search.php'; ?>
  <div class="info-stats">
    <div class="profile-information">
      <img id="profile-picture-info" <?php echo "src=\"uploads/profile-$uid.png\"" ?>/>
      <div class="user-info">
        <span class="name"><b><?php echo $user["firstName"]." ".$user["lastName"]; ?></b></span>
        <span class="username"><?php echo "@".$user["username"] ?></span>
      </div>
    </div>
    <div class="profile-statistics">
      <div class="count-container reputation">
        <div class="icon-container">
          <i class="fa-solid fa-handshake"></i>
        </div>
        <div class="value-container">
          <span class="value"><?php echo "N/A"; ?></span>
        </div>
      </div>
      <div class="count-container discussion">
        <div class="icon-container">
          <i class="fa-solid fa-newspaper"></i>
        </div>
        <div class="value-container">
          <span class="value"><?php echo $countDiscussions; ?></span>
        </div>
      </div>
      <div class="count-container reply">
        <div class="icon-container">
          <i class="fa-brands fa-replyd"></i>
        </div>
        <div class="value-container">
          <span class="value"><?php echo $countReplies; ?></span>
        </div>
      </div>
    </div>
  </div>
  <div class="body-section">
    <div class="bio-stats-container">
      <div class="bio-container container-spacing">
        <div class="label-container">
          <h1>Biography</h1>
          <span>Learn more about <?php echo "@".$user["username"] ?>, from the <?php echo "@".$user["username"] ?>.</span>
        </div>
        <div class="biography-text-container">
          <span class="biography-text"><?php echo $user["biography"]; ?></span>
        </div>
        <!-- <div class="bio"></div> -->
      </div>  
      <div class="socials-container container-spacing">
        <div class="label-container">
          <h1>Connections</h1>
          <span>Follow <?php echo "@".$user["username"] ?> outside discussIt.</span>
        </div>
        <div class="socials">
          <?php 
            $twitter = $user["twitterAccount"];
            $linkedin = $user["linkedinAccount"];
            $pgweb = $user["pgwebAddress"];

            if(($twitter || $linkedin || $pgweb)){
                echo '
                  <div class="no-connections">
                    <div class="social-icon-container">
                      <i class="fa-solid fa-diagram-project fa-bounce"></i>
                    </div>
                    <div class="social-label-container">
                      <span class="social-label">No Connections Found!</span>
                    </div>
                  </div>
                ';
            } else {
              if($twitter){
                echo '
                  <a href="'.$twitter.'">
                    <div class="twitter">
                      <div class="social-icon-container">
                        <i class="fa-brands fa-twitter fa-bounce"></i>
                      </div>
                      <div class="social-label-container">
                        <span class="social-label">Twitter</span>
                      </div>
                    </div>
                  </a>
                ';
              }
              if($linkedin){
                echo '
                  <a href="'.$linkedin.'">
                    <div class="linkedin">
                      <div class="social-icon-container">
                        <i class="fa-brands fa-linkedin fa-bounce"></i>
                      </div>
                      <div class="social-label-container">
                        <span class="social-label">LinkedIn</span>
                      </div>
                    </div>
                  </a>
                ';
              }
              if($pgweb){
                echo '
                  <a href="'.$pgweb.'">
                    <div class="personal-website">
                      <div class="social-icon-container">
                        <i class="fa-solid fa-globe fa-bounce"></i>
                      </div>
                      <div class="social-label-container">
                        <span class="social-label">Personal Website</span>
                      </div>
                    </div>
                  </a>
                ';
              }
            }
          ?>
        </div>
      </div>
      <!-- <div class="stats-container container-spacing">
        <div class="label-container">
          <h1>Recent Activity</h1>
          <span>Shows reputation earning trends for @KateWilson.</span>
        </div>
        <div class="stats"></div>
      </div> -->
    </div>
    <div class="contributions-container">
      <div class="label-container">
        <h1>Recent Contributors</h1>
        <span>Recent contributions (i.e. Discussion Posts & Replies)</span>
      </div>
      <div class="discussions-list">
      <?php
        if($contributions){
          foreach($contributions as $contribution){
            if($contribution["isVisible"] == 1){
              $discussionid = $contribution["id"];
              $authorid = $contribution["authorId"];
              $authorUsername = getUserByID($conn, $authorid)["username"];
              $postTitle = $contribution["postTitle"];
              $topics = getTopics($conn, $discussionid);

              echo "
                <a href=\"./discussion.php?id=$discussionid\">
                  <div class=\"discussion-minimal\">
                    <h1>$postTitle</h1>
                    <div class=\"discussion-info\">
                      <div class=\"author-info\">
                        <img id=\"author-picture\" src=\"uploads/profile-$authorid.png\"/>
                        <div class=\"author-details\">
                          <p class=\"name\">$authorUsername</p>
                        </div>
                      </div>
                      <div class=\"topics\">";

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
                    
                      echo "</div>
                    </div>
                  </div>
                </a>
              ";
            }
          }
        }
      ?>
      </div>
    </div>
  </div>
</body>
</html>