<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="../css/navigation-bar-v2.css">
  <!-- EXTERNAL SCRIPTS -->
  <script src="https://kit.fontawesome.com/ec7e0e3eb8.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.js"
integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
  <script src="../js/navigation.js"></script>
</head>
<body>
    <nav class="nav-bar">
      <div class="section-a">
        <a href="../index.php"><img class="logo" src="../images/logoDarkBlue.png" alt="img"></a>
        <div style="display: flex; justify-content: start;">
          <a href="../index.php">Feed</a>
          <a href="#">Discover</a>
        </div>
      </div>
    <form>
      <input type="text" class="nav-search" placeholder="Search">
    </form>
    
    <div class="section-b">
      <?php
        if(isset($_SESSION["uid"])){
          // LOGGED IN
          echo '
            <div class="notifications">
              <button class="notification-dropdown">
                <i class="fa-solid fa-bell"></i>
              </button>
            </div>
            
            <div class="dropdown">
              <button class="logged-in">
                <img id="profile-picture" src="uploads/profile-', $_SESSION["uid"] ,'.png"/>
                <span>', $_SESSION["uname"], '</span> &nbsp;<i class="fa-solid fa-angle-down"></i>
              </button>
              <div id="myDropdown" class="dropdown-content">
              <a class="disabled"><i class="fa-solid fa-circle-info"></i> &nbsp;Terms & Policies</a>';
          if((getUserByID($conn, $_SESSION["uid"])["administratorPermissions"])){
            echo '
              <a href="./administrator-portal.php"><i class="fa-solid fa-hammer"></i> &nbsp;Admin Portal</a>
            '; 
          }      
          echo '
                <a href="../scripts/logout-script.php"><i class="fa-solid fa-circle-info"></i> &nbsp;Log Out</a>
              </div>
            </div>
          </div>
          ';
        }
        else {
          // LOGGED OUT
          echo '
            <div id="login-cont">
              <a href="../login.php">
                <button class="login-btn">
                  <i class="fa-solid fa-right-to-bracket"></i>&nbsp;&nbsp;<span>Log In</span>
                </button>
              </a>
            </div>
            
            <div class="dropdown">
              <button class="log-in">
                <i class="fa-regular fa-user"></i> &nbsp;<i class="fa-solid fa-angle-down"></i>
              </button>
              <div id="myDropdown" class="dropdown-content">
                <a href="#"><i class="fa-solid fa-circle-info"></i> &nbsp;Terms & Policies</a>
              </div>
            </div>
          ';
        }
      ?>
  </nav>
</body>
</html>