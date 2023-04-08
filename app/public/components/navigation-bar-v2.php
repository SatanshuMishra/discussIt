<nav class="nav-bar">
  <div class="section-a">
    <a href="./index.php"><img id="nav-logo-ref" class="logo" src="./images/logoDarkBlue.png" alt="img"></a>
    <div style="display: flex; justify-content: start;">
      <a href="./index.php">Feed</a>
      <a href="./discover.php">Discover</a>
    </div>
  </div>
  <form class="nav-v2-form" action="./scripts/search-script.php" method="POST">
    <input type="text" name="search-string" class="nav-search" placeholder="Search">
    <div class="nav-search-info">
      <i class="fa-solid fa-circle-info"></i>
      <div class="nav-tooltip-container">
        <h3 style="padding: 0.2em 0;">Search Tips:</h3>
        <p style="padding: 0.2em 0;"><span style="padding: 0.2em 0.4em; background-color:#0059ff; border-radius: 10px; color: #fff">@Username</span> Can be used to search for discussions by a specific user. (E.g. @SatanshuMishra)</p>
        <p style="padding: 0.2em 0;"><span style="padding: 0.2em 0.4em; background-color:#0059ff; border-radius: 10px; color: #fff">#Topic</span> Can be used to search for discussions under a specific topic. (E.g. #Space)</p>
        <p style="padding: 0.2em 0;">Any other text not begining with the prefixes mentioned above will be looked for in the title of the discussion.</p>
        <p style="padding: 0.2em 0;"><b>Note:</b> You may chain the search parameters above for more specific results. You may only have <b style="color: #ff3d3d">one username</b> per search.</p>
      </div>
    </div>
  </form>

  <div class="section-b">
    <?php
      if(isset($_SESSION["uid"])){
        // LOGGED IN
        echo '
<!--        <div class="create-post">
          <a href="./Creatediscussion.php">
            <button class="start-discussion-btn-navigation">
              <i class="fa-solid fa-feather"></i>
            </button>
          </a>
        </div> -->
          
          <div class="dropdown">
            <button class="logged-in">
              <img id="profile-picture" src="uploads/profile-', $_SESSION["uid"] ,'.png"/>
              <span>', $_SESSION["uname"], '</span> &nbsp;<i class="fa-solid fa-angle-down"></i>
            </button>
            <div id="myDropdown" class="dropdown-content">
            <a href="./SettingsDirectory.php"><i class="fa-solid fa-gear"></i> &nbsp;Settings</a>
            <a class="disabled"><i class="fa-solid fa-book"></i> &nbsp;Terms & Policies</a>';
        if((getUserByID($conn, $_SESSION["uid"])["administratorPermissions"])){
          echo '
            <a href="./administrator-dashboard.php"><i class="fa-solid fa-hammer"></i> &nbsp;Admin Portal</a>
          '; 
        }      
        echo '
        <a href="./previewaccount.php?userid='.$_SESSION["uid"].'"><i class="fa-solid fa-circle-info"></i> &nbsp;View Account</a>
              <a href="./scripts/logout-script.php"><i class="fa-solid fa-door-open"></i> &nbsp;Log Out</a>
            </div>
          </div>
        </div>
        ';
      }
      else {
        // LOGGED OUT
        echo '
          <div id="login-cont">
            <a href="./login.php">
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
              <a href = "../termsofSite.php" class="disabled"><i class="fa-solid fa-circle-info"></i> &nbsp;Terms & Policies</a>
            </div>
          </div>
        ';
      }
    ?>
  </div>
</nav>