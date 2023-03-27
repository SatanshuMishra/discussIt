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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/administrator-portal.css">
  <!-- LOCAL JS -->
  <script src="js/admin-portal.js"></script>
  <!-- HEADER INCLUDE -->
  <?php include_once "./includes/header-information.php"; ?>
  <title>Admin Portal</title>
</head>
<body>
  <?php 

  ?>
  <nav class="nav-sidebar">
    <div class="upper-section">
      <div class="logo-container">
        <img class="logo" src="./images/logoDarkBlue.png" alt="">
        <span class="logo-text">discussIt</span>
      </div>
      <hr class="solid">
      <ul class="nav-list">
        <a class="disabled">
          <li class="nav-option">
            <!-- fa-bounce -->
            <i class="fa-solid fa-chart-pie"></i>
            Dashboard
          </li>
        </a>
        <a class="disabled">
          <li class="nav-option">
            <i class="fa-regular fa-envelope"></i>
            Announcements
          </li>
        </a>
      </ul>
      <hr class="solid">
      <ul class="nav-list">
        <a href="#">
          <li class="nav-option active">
            <i class="fa-regular fa-user"></i>
            Members
          </li>
        </a>
        <a href="#">
          <li class="nav-option">
            <i class="fa-regular fa-message"></i>
            Discussions
          </li>
        </a>
      </ul>
    </div>
    <div class="lower-section">
      <div class="profile-image-conatainer">
        <img <?php echo 'src="./uploads/profile-'.$_SESSION["uid"].'.png?version=1231231"' ?> alt="ProflePicture">
        <span><?php echo $sessionUser["firstName"].$sessionUser["lastName"] ?></span>
      </div>
      <div class="exit-container">
        <a href="./index.php">
          <i class="door-hover fa-solid fa-door-open"></i>
        </a>
      </div>
    </div>
  </nav>
  <div class="content">
    <div class="header-container">
      <div class="view-info-container">
        <div class="icon-container">
          <i class="fa-regular fa-user"></i>
        </div>
        <span>Members</span>
      </div>
      <div class="filter-container">
        <form action="#" method="post">
          <input type="text" name="search" id="search" placeholder="Search User">

          <?php 
            //TODO: ADD ORDER-BY FUNCTIONALITY 
          ?>

          <input class="search-submit" type="submit" value="Submit" />
        </form>
      </div>
    </div>
    <div class="members-content">
      <table id="members">
        <tr>
          <th class="header-cell">Name</th>
          <!-- <th></th> -->
          <th class="header-cell">Roles</th>
          <th class="header-cell">Actions</th>
        </tr>
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
                  <!-- <td>
                    <div class="unknown">Unknown</div>
                  </td> -->
                  <td class="roles">
                    <div class="cell">';
                    if($user["administratorPermissions"]){
                      echo '<div class="admin">Admin</div>';
                    } else {
                      echo '<div class="member">Member</div>';
                    }
                    echo '</div>
                  </td>
                  <td class="options">
                    <div class="cell">
                      <div id="'.$user["id"].'" class="option edit">
                        <i class="fa-solid fa-brush"></i>&#9; 
                        <span>Modify Account</span>
                      </div>
                      <a class="delete-link-btn" href="./scripts/remove-account.php?iAFgo3q5J2hfCTv1SShA=true&uid='.$user["id"].'">
                        <div class="option delete">
                          <i class="fa-solid fa-trash"></i>
                          <span>Remove Account</span>
                        </div>
                      </a>
                    </div>
                  </td>
                </tr>
              ';

              echo '
                <div class="modal-container modal-'.$user["id"].'">
                    <div class="modal">
                      <form class="modal-form" action="./scripts/admin-update-user.php" method="post">
                        <input type="hidden" name="userid" value="'.$user["id"].'">
                        <div class="horizontal-container" style="margin: 0 0 1em 0;">
                          <i class="fa-solid fa-brush" style="font-size: 50px; margin-right: 0.2em"></i>
                          <div class="vertical-container">
                            <h1>Modify Account</h1>
                            <span>Modify '.$user["username"].'\'s account details!</span>
                          </div>
                        </div>
                        <div class="horizontal-container">
                          <div class="vertical-container">
                            <label for="username">Username</label>
                            <input class="input-field" type="text" name="username" id="username" value="'.$user["username"].'">
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
                            <label for="demerit-points">Demerit Points</label>
                            <input type="number" class="input-field"  min="0" max="3" name="demerit-points" id="demerit-points" value="'.$user["demeritPoints"].'">
                          </div>
                          <div class="vertical-container">
                            <label for="isAdmin">Is Administrator</label>
                            <input class="input-field" type="number" min="0" max="1" name="isAdmin" id="isAdmin" value="'.$user["administratorPermissions"].'">
                          </div>
                        </div>
                        <div class="horizontal-container">
                          <!-- <img id="modal-profile-image" src="./uploads/profile-1.png" alt="profile-picture-modal"> -->
                          <div class="vertical-container">
                            <label for="reset-profile-picture">Reset Profile Picture</label>
                            <input class="input-field" type="number" min="0" max="1" name="reset-profile-picture" id="reset-profile-picture" value="0">
                          </div>
                        </div>
                        <div class="horizontal-container">
                          <button class="modal-btn modal-cancel-btn" type="button">Cancel</button>  
                          <button class="modal-btn modal-reset-btn" type="reset">Reset Form</button>  
                          <button type="submit" class="modal-btn modal-submit-btn" name="submit">Submit Changes</button>
                        </div>
                      </form>
                    </div>
                </div>
              ';
            }
          }
        ?>
      </table>
    </div>
  </div>
</body>
</html>