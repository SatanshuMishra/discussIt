<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="../css/navigation-bar.css">
  <!-- EXTERNAL SCRIPTS -->
  <script src="https://kit.fontawesome.com/ec7e0e3eb8.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.js"
integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
  <script src="../js/navigation.js"></script>
</head>
<body>
    <nav class="nav-bar">
    <a href="../index.php"><img class="logo" src="../images/logoDarkBlue.png" alt="img"></a>
    <form>
      <input type="text" class="nav-search" placeholder="Search">
    </form>
    <div class="dropdown">
      <button class="log-in">
        <?php
          if(isset($_SESSION["uid"])){
            echo $_SESSION["uname"] , '&nbsp;&nbsp;<i class="fa-solid fa-angle-down"></i>';
          }
          else {
            echo '<i class="fa-regular fa-user"></i> &nbsp;<i class="fa-solid fa-angle-down"></i>';
          }
        ?>
        <!-- <i class="fa-regular fa-user"></i> &nbsp;<i class="fa-solid fa-angle-down"></i> -->
      </button>
      <div id="myDropdown" class="dropdown-content">
        <a href="#"><i class="fa-solid fa-circle-info"></i> &nbsp;Terms & Policies</a>
        <?php
          if(isset($_SESSION["uid"])){
            echo '<a href="#"><i class="fa-solid fa-gear"></i> &nbsp;Settings</a>';
            echo '<a href="../scripts/logout-script.php"><i class="fa-regular fa-circle-question"></i> &nbsp;Log Out</a>';
          } else{
            echo '<a href="../login.php"><i class="fa-regular fa-circle-question"></i> &nbsp;Log In / Sign Up</a>';
          }
        ?> 
      </div>
    </div>
  </nav>
</body>
</html>