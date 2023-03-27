<?php session_start();
  if(!isset($_SESSION["uid"])){
    header("Location: ./index.php?error=cannotcreatediscussionnotloggedin");
    exit();
  }
?>
<!DOCTYPE html>
<html lang= "en">
<head>
    <!-- EXTERNAL CSS -->
    <link rel="stylesheet" href="css/Creatediscussion.css">
    <!-- LOCAL JS -->
    <script type="text/javascript" src="./js/discussion.js"></script>
    <!-- HEADER INCLUDE -->
    <?php include_once "./includes/header-information.php"; ?>
    <title>Create a Discussion</title>
</head>
<body>
  <?php include_once 'components/navigation-bar-v2-no-search.php'; ?>
  <div class="indicator-container">
    <div class="progress-indicator current-page">
        <span>1</span>
    </div>
    <div class="progress-indicator">
        <span>2</span>
    </div>
    <div class="progress-indicator">
        <span>3</span>
    </div>
  </div>
  <div class="header-container">
    <h1>Choose Your Topics</h1>
    <span>Please choose what topics your discussion will be about.</span> 
    <div class="information-container">
      <span><i class="fa-solid fa-circle-question"></i> &nbsp;<b>Note</b>: You may only choose between 1 - 2 topics for each discussion.</span>
    </div>  
  </div>

  <div class="topics-container">
    <div class="topic-slider">
      <div class="slider">
        <a class="slider-item" onclick="addTopic(this)" >
          <div class="item-container cooking">
            <span>COOKING</span>
          </div>
        </a>
        <a class="slider-item" onclick="addTopic(this)">
          <div class="item-container gaming">
            <span>GAMING</span>
          </div>
        </a>
        <a class="slider-item" onclick="addTopic(this)">
          <div class="item-container q&a">
            <span>Q&A</span>
          </div>
        </a>
        <a class="slider-item" onclick="addTopic(this)">
          <div class="item-container space">
            <span>SPACE</span>
          </div>
        </a>
        <a class="slider-item" onclick="addTopic(this)" >
          <div class="item-container sports">
            <span>SPORTS</span>
          </div>
        </a>
        <a class="slider-item" onclick="addTopic(this)" >
          <div class="item-container positivity">
            <span>POSITIVITY</span>
          </div>
        </a>
        <a class="slider-item" onclick="addTopic(this)" >
          <div class="item-container news">
            <span>NEWS</span>
          </div>
        </a>
      </div>
    </div>
  </div>

  <div class="body-container">
    <form id="form1" method="POST" action="scripts/passTopics-script.php" onsubmit="checkCondition(event)">
      <div class="selected-topics-container">
        <span>Selected Topics:</span>
        <ul id="selected-topics" name="selected-topics">
          <!-- <div class="pill space">
            <span class="name">Space</span>
          </div> -->
        </ul>
        <input type="hidden" id="topicsArray" name="topicsArray[]" value="">
        <div class="remove-button">
          <button type="button" class="btn-formatted remove" id="remove" onclick="removeTopic()">Remove Topic</button>
        </div>
        
      </div>
      <div class="progression-btn-container">
        <div class="cancel-button">
          <a href="index.php"><button class="btn-formatted cancel">Cancel</button></a>
        </div>
        <div class="continue-button">
          <button class="btn-formatted continue" id="continue-btn" type="submit" name="submit" value="Submit">Continue</button>
        </div>
      </div>
    </form>
  </div>

  <script>
    let topicSliderA = document.querySelector(".topic-slider");
    let topicSlider = $(".topic-slider");
    var maxScrollLeft = topicSliderA.scrollWidth - topicSliderA.clientWidth;
    topicSlider.scrollLeft(maxScrollLeft / 2);

    function checkCondition(e) {
      const ul = document.querySelector("ul");
      const numberOfItems = ul.querySelectorAll("li").length;
      if (numberOfItems <= 0) {
        e.preventDefault();
        alert("You must choose at least one topic.");
        return false;
      }
    }
    // function removeTopic() {
    //   const ul = document.querySelector("ul");
    //   const lastItem = ul.lastElementChild;
    //   ul.removeChild(lastItem);
    //   i--;
    // }
  </script>

  <?php include_once "./components/footer.php"; ?>
</body>
</html>