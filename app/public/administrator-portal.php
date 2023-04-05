<?php session_start(); 
  if(!isset($_SESSION["uid"])){
    header("Location: ./index.php?invalidadminaccessnotloggedin");
    exit();
  }
  require_once "./scripts/config.php";
  require_once "./scripts/functions-scripts.php";
   
  if(!(getUserByID($conn, $_SESSION["uid"])["administratorPermissions"])){
    header("Location: ./index.php?invalidadminaccessnotadmin");
    exit();
  }
  $sessionUser = getUserByID($conn, $_SESSION["uid"]);
  header("Expires: Tue, 01 Jan 2000 00:00:00 GMT");
  header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
  header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
  header("Cache-Control: post-check=0, pre-check=0", false);
  header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/administrator-portal.css">
  <!-- LOCAL JS -->
  <!-- <script src="js/admin-portal.js"></script> -->
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title>Admin Portal</title>
</head>
<body>
  <nav class="nav-sidebar">
    <div class="upper-section">
      <div class="logo-container">
        <img class="logo" src="./images/logoDarkBlue.png" alt="">
      </div>
      <!-- <hr class="solid"> -->
      <ul class="nav-list">
        <a class="disabled">
          <li class="nav-option">
            <i class="fa-solid fa-chart-pie"></i>
          </li>
        </a>
        <a class="disabled">
          <li class="nav-option">
            <i class="fa-regular fa-envelope"></i>
          </li>
        </a>
      </ul>
      <!-- <hr class="solid"> -->
      <ul class="nav-list">
        <a href="./administrator-portal.php">
          <li class="nav-option active">
            <i class="fa-regular fa-user"></i>
          </li>
        </a>
        <a href="./administrator-discussions.php">
          <li class="nav-option">
            <i class="fa-regular fa-message"></i>
          </li>
        </a>
      </ul>
    </div>
    <div class="lower-section">
      <div class="profile-image-conatainer">
        <img <?php echo 'src="./uploads/profile-'.$_SESSION["uid"].'.png?version=1231231"' ?> alt="ProflePicture">
      </div>
      <div class="exit-container">
        <a href="./index.php">
          <i class="fa-solid fa-door-open"></i>
        </a>
      </div>
    </div>
  </nav>

    <div class="toast">
    <div class="toast-content">
      <i class="fa-solid fa-bell check-icon"></i>
      <div class="message">
        <span class="text-toast text-1"></span>
        <span class="text-toast text-2"></span>
      </div>
    </div>
    <i class="fa-solid fa-xmark close-icon"></i>
    <div class="progress">
    </div>
  </div>

  <div class="content">
    <div class="header-container">
      <div class="view-info-container">
        <div class="icon-container">
          <i class="fa-regular fa-user"></i>
        </div>
        <span>Members</span>
      </div>
      <div class="filter-container">
        <form method="post">
          <input type="text" name="search" id="search" placeholder="Search User">

          <?php 
            //TODO: ADD ORDER-BY FUNCTIONALITY 
          ?>
          <input class="search-submit disabled" type="button" value="Submit" />
        </form>
      </div>
    </div>
    <div class="members-content">
      <div class="modal-container">
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
              <img id="modal-profile-image" src="./uploads/profile-1.png" alt="profile-picture-modal">
              <div class="vertical-container">
                <h2>Satanshu Mishra</h2>
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
                <input type="number" class="input-field"  min="0" max="3" name="demerit-points" id="demerit-points" value="2">
              </div>
              <div class="vertical-container">
                <label for="isAdmin">Permissions</label>
                  <select id="cars" name="cars">
                  <option value="member">Member</option>
                  <option value="administrator">Administrator</option>
                </select>
              </div>
            </div>
            <div class="horizontal-container" style="justify-content: end !important;">
              <button class="modal-btn modal-cancel-btn" type="button">Cancel</button>  
              <button class="modal-btn modal-reset-btn" type="reset">Reset Form</button>  
              <button type="submit" class="modal-btn modal-submit-btn" name="submit">Submit Changes</button>
            </div>
          </form>
        </div>
      </div>
      <table id="members" class="members-table">
        <tr>
          <th class="header-cell">Name</th>
          <th class="header-cell">Status</th>
          <th class="header-cell">Roles</th>
          <th class="header-cell">Actions</th>
        </tr>
        <tbody id="table-body">
        <?php 
          $users = getUsers($conn);
          if($users){
            foreach($users as $user){
              echo '
                <tr class="member-row">
                  <td class="name">
                    <div class="cell name-cell">
                      <img src="./uploads/profile-'.$user["id"].'.png?version=1231231" />
                      <div class="text-info">
                        <span class="name">'.$user["firstName"].' '.$user["lastName"].'</span>
                        <span class="username">@'.$user["username"].'</span>
                      </div>
                    </div>
                  </td>
                  <td class="roles">
                    <div class="cell">'.
                      (($user['isSuspended']) ? '<div class="suspended">Suspended</div>' : '<div class="active-member">Active</div>')
                  .'</div>
                  </td>
                  <td class="roles">
                    <div class="cell">'.
                      (($user["administratorPermissions"]) ? '<div class="admin">Admin</div>' : '<div class="member">Member</div>')
                  .'</div>
                  </td>
                  <td class="options">
                    <div class="cell">
                      <a class="delete-link-btn" href="./administrator-modify.php?userId='.$user["id"].'">
                        <span class="tooltip" data-text="Modify Account">
                          <div id="edit-'.$user["id"].'" class="option edit">
                            <i class="fa-solid fa-brush"></i>
                          </div>
                        </span>
                      </a>
                      <a class="delete-link-btn" href="./scripts/suspend-account.php?iAFgo3q5J2hfCTv1SShA=true&uid='.$user["id"].'">
                        <span class="tooltip" data-text="Suspend Account">
                          <div class="option suspend">
                            <i class="fa-solid fa-icicles"></i>
                          </div>
                        </span>
                      </a>
                      <a class="delete-link-btn" href="./scripts/remove-account.php?iAFgo3q5J2hfCTv1SShA=true&uid='.$user["id"].'">
                        <span class="tooltip" data-text="Ban Account">
                          <div class="option ban">
                            <i class="fa-solid fa-ban"></i>
                          </div>
                        </span>
                      </a>
                    </div>
                  </td>
                </tr>
              ';
            }
          }
        ?>
        </tbody>
      </table>
    </div>
  </div>
  <script>
    $(document).ready(function () {
      let toast = document.querySelector(".toast");
      let close = document.querySelector(".close-icon");
      let progress = document.querySelector(".progress");
      console.log(toast);
      console.log(close);
      console.log(progress);

      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);

      console.log(queryString);
      console.log(urlParams);
      if(urlParams.has('message')){
        let title = document.querySelector(".text-1");
        let description = document.querySelector(".text-2");
        if(urlParams.get('message') == "usersuccessfullysuspended"){
          title.innerHTML= "Success";
          description.innerHTML= "The user was successfully suspended!";
        } else if(urlParams.get('message') == "usersuccessfullyunsuspended"){
          title.innerHTML= "Success";
          description.innerHTML= "The user account un-suspended!";
        } else if(urlParams.get('message') == "usersuccessfullyremoved"){
          title.innerHTML= "Success";
          description.innerHTML= "The user was successfully banned!.";
        } 
        setTimeout(() => {
          toast.classList.add("active-toast");
          progress.classList.add("active-toast");
          
          setTimeout(() => {
            toast.classList.remove("active-toast");
          }, 5000);
        }, 50);
      }

      close.addEventListener("click", () => {
        toast.classList.remove("active-toast");
      })

      function loadUsers() {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', './scripts/loadAdminUsers.php');
        xhr.send();

        xhr.onload = function(){
          if (xhr.status != 200) { // analyze HTTP status of the response
            console.log(`Error ${xhr.status}: ${xhr.statusText}`); // e.g. 404: Not Found
          } else { // show the result
            document.querySelector('#table-body').innerHTML = xhr.response; // response is the server response
          }
        }
        window.setTimeout(loadUsers, 1000);
      }
      loadUsers();
    });
  </script>
</body>
</html>