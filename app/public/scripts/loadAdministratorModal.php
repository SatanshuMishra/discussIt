<?php session_start();
  if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['id'])){
      require_once 'config.php';
      require_once 'functions-scripts.php';
      $user = getUserByID($conn, $_POST['id']);
      echo '
          <div class="modal">
            <div class="horizontal-container" style="margin: 0 0 1em 0;">
              <i class="fa-solid fa-brush" style="font-size: 50px; margin-right: 0.2em"></i>
              <div class="vertical-container">
                <h1>Modify Account</h1>
              </div>
            </div>
            <form class="modal-form" action="./scripts/admin-update-user.php" method="post">
              <input type="hidden" name="userid" value="[USER ID]">
              <div class="horizontal-container" style="padding: 0 0 1.5em 0">
                <img id="modal-profile-image" src="./uploads/profile-'.$user["id"].'.png" alt="profile-picture-modal">
                <div class="vertical-container">
                  <h2>'.$user["firstName"]." ".$user["lastName"].'</h2>
                  <div class="horizontal-container">
                    <input class="input-field" type="checkbox" name="form-profile-reset" id="form-profile-reset" style="margin-right: 0.5em;">
                    <label for="form-profile-reset">Reset Profile Picture</label>
                  </div>
                </div>
              </div>
              <div class="horizontal-container">
                <div class="vertical-container">
                  <label for="firstname">Firstname</label>
                  <input class="input-field" type="text" name="firstname" id="firstname" value="'.$user["firstName"].'">
                </div>
                <div class="vertical-container">
                  <label for="lastname">Lastname</label>
                  <input class="input-field" type="text" name="lastname" id="lastname" value="'.$user["lastName"].'">
                </div>
              </div>
              <div class="horizontal-container">
                <div class="vertical-container">
                  <label for="username">Username</label>
                  <input class="input-field" type="text" name="username" id="username" value="'.$user["username"].'">
                </div>
                <div class="vertical-container">
                  <label for="reset-password">Reset Password</label>
                  <input class="input-field" type="number" min="0" max="1" name="reset-password" id="reset-password" value="'.$user["administratorPermissions"].'">
                </div>
              </div>
              <div class="horizontal-container">
                <div class="vertical-container">
                  <label for="demerit-points">Demerit Points</label>
                  <input type="number" class="input-field"  min="0" max="3" name="demerit-points" id="demerit-points" value="'.$user["demeritPoints"].'">
                </div>
                <div class="vertical-container">
                  <label for="isAdmin">Permissions</label>
                    <select id="isAdmin" name="isAdmin" value="administrator">
                      <option value="member">Member</option>
                      <option value="administrator">Administrator</option>
                    </select>
                </div>
              </div>
              <div class="horizontal-container">
                <button class="modal-btn modal-cancel-btn" type="button">Cancel</button>
                <button class="modal-btn modal-reset-btn" type="reset">Reset Form</button>  
                <button type="submit" class="modal-btn modal-submit-btn" name="submit">Submit Changes</button>
              </div>
            </form>
            <script>
              document.querySelector(\'.modal-cancel-btn\').addEventListener("click", () => {
                console.log("Cancel clicked");
                modal.style.display = "none"; 
              });
            </script>
          </div>  
      ';
    
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