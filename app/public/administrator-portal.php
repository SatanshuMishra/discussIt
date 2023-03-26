<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="images/logoDarkBlue.png">
  <!-- EXTERNAL CSS -->
  <link rel="stylesheet" href="css/administrator-portal.css">
  <!-- EXTERNAL SCRIPTS -->
  <script src="https://kit.fontawesome.com/ec7e0e3eb8.js" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.1.1.js"
integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
  <title>Home of Discussions</title>
</head>
<body>
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
        <img src="./uploads/profile-1.png" alt="ProflePicture">
        <span>Satanshu Mishra</span>
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
        <tr class="member-row">
          <td class="name">
            <div class="cell name-cell">
              <img src="./uploads/profile-1.png" />
              <div class="text-info">
                <span class="name">Satanshu Mishra</span>
                <span class="username">@SatanshuMishra</span>
              </div>
            </div>
          </td>
          <!-- <td>
            <div class="unknown">Unknown</div>
          </td> -->
          <td class="roles">
            <div class="cell">
              <div class="member">Member</div>
              <!-- <div class="admin">Admin</div> -->
            </div>
          </td>
          <td class="options">
            <div class="cell">
              <div class="option edit">
                <i class="fa-solid fa-brush"></i>&#9; 
                Modify Account
              </div>
              <div class="option delete">
                <i class="fa-solid fa-trash"></i>
                Remove Account
              </div>
            </div>
          </td>
        </tr>
      </table>
    </div>
  </div>
</body>
</html>