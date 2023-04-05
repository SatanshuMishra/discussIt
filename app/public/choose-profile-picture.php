<?php 
  session_start();
  if(!isset($_SESSION["uid"])){
    header("location: ../index.php?error=profilenotloggedin");
    exit();
  }
  $id = $_SESSION["uid"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <!-- LOCAL CSS -->
  <link rel="stylesheet" href="css/choose-profile-picture.css">
  <!-- LOCAL JS -->
  <script src="js/welcome.js"></script>
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title>Welcome</title>
</head>
<body>
  <element id="reference-element"></element>
  <?php include_once 'components/navigation-bar-v2-no-search.php'; ?>

  <div class="container">
    <div class="image-container">
      <img id="login-illustration" src="images/profile-picture-illustration.svg" alt="">
    </div>
    <div class="form-container">
      <h1>Personalization</h1>
      <span class="textDescription">Personalize your account, make it truely unique and true to who you are!</span>

        <form id="welcome-form" action="scripts/upload-script.php" method="post" enctype="multipart/form-data">
          <!-- BIOGRAPHY -->
          <!-- <div class="bio-container">
            <h2>Biography</h2>
            <span class="span-format margin-top-exempt">Tell other know more about you:</span>  
            <textarea id="bio-container" name="post-reply-content" rows="3" placeholder="Enter Biography"></textarea>
          </div> -->

          <!-- PROFILE PICTURE -->
          <h2>Choose a profile picture</h2>
          <span class="span-format margin-top-exempt">Upload a unique profile picture:</span>
          <div class="profile-picture-container">
            <?php
              echo "<img id=\"profile-picture-preview\" src=\"uploads/profile-$id.png\"/>";
            ?>
            <input id="formSubmitValue" type="hidden" name="submitValue" value="0">
            <label id="choose-photo-label" for="file-selector-input">Choose Picture</label>
            <input id="file-selector-input" type="file" name="upload-photo" onchange="formSubmit()">
          </div>

          <!-- SOCIALS -->
          <!-- <div class="socials-container">
            <h2>Socials & Connections</h2>
            <span class="span-format margin-top-exempt">Add your socials so others can follow you outside our website:</span>
            <div class="input-container">
              <div class="twitter-input-container inputs">
                <label class="span-format" for="twitter-social">Twitter</label>
                <input type="text" name="twitter-social" id="twitter-social" class="text-input" placeholder="Link to Twitter Profile">
              </div>
              <div class="linkedin-input-container inputs">
                <label class="span-format" for="linkedin-social">LinkedIn</label>
                <input type="text" name="linkedin-social" id="linkedin-social" class="text-input" placeholder="Link to LinkedIn Profile">
              </div>
              <div class="pweb-input-container inputs">
                <label class="span-format" for="pweb-social">Personal Website</label>
                <input type="text" name="pweb-social" id="pweb-social" class="text-input" placeholder="Link to Personal Website">
              </div>
            </div>
          </div> -->
        </form>
      <div class="btnCont">
        <form action="./scripts/personalize-user.php" method="post">
          <!-- BIOGRAPHY -->
          <div class="bio-container">
            <h2>Biography</h2>
            <span class="span-format margin-top-exempt">Tell other know more about you:</span>  
            <textarea id="bio-container" name="bio-text" rows="3" placeholder="Enter Biography"></textarea>
          </div>
          <!-- SOCIALS -->
          <div class="socials-container">
            <h2>Socials & Connections</h2>
            <span class="span-format margin-top-exempt">Add your socials so others can follow you outside our website:</span>
            <div class="input-container">
              <div class="twitter-input-container inputs">
                <label class="span-format" for="twitter-social">Twitter</label>
                <input type="text" name="twitter-social" id="twitter-social" class="text-input" placeholder="Link to Twitter Profile">
              </div>
              <div class="linkedin-input-container inputs">
                <label class="span-format" for="linkedin-social">LinkedIn</label>
                <input type="text" name="linkedin-social" id="linkedin-social" class="text-input" placeholder="Link to LinkedIn Profile">
              </div>
              <div class="pweb-input-container inputs">
                <label class="span-format" for="pweb-social">Personal Website</label>
                <input type="text" name="pweb-social" id="pweb-social" class="text-input" placeholder="Link to Personal Website">
              </div>
            </div>
          </div>
          <div class="submit-container">
            <button type="submit" name="submit" class="continue-btn">
              Continue
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script>
    function formSubmit(){
      let form = $('#welcome-form');
      $('#formSubmitValue').attr('value', 1);
      console.log($('#formSubmitValue').attr('value'));
      form.submit();
    }
  </script>
  <?php include_once "./components/footer.php"; ?>
</body>
</html>